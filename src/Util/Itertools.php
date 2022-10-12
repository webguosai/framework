<?php

namespace Webguosai\Util;

use Webguosai\Helper\Str;

/**
 * 仿python itertools模块
 *
 * 这个也可以使用：https://github.com/drupol/phpermutations
 * 演示：
    // 迭代所有组合
    $permutations = Itertools::permutations('abc');
    foreach ($permutations as $permutation) {
        dump(implode($permutation));
    }
 *
 * 附上python版本(迭代所有组合)
    from itertools import permutations
    from random import shuffle

    def shuffled_permutations(s):
    perms = list(permutations(s))
    # 加这个会随机
    # shuffle(perms)
    return ["".join(p) for p in perms]

    print(shuffled_permutations("abc"))
 */
class Itertools
{
    public static function slice($start_or_stop, $stop = PHP_INT_MAX, $step = 1)
    {
        if (func_num_args() === 1) {
            return (object) [
                'start' => 0,
                'stop'  => $start_or_stop,
                'step'  => $step,
            ];
        }

        return (object) [
            'start' => $start_or_stop,
            'stop'  => $stop === null ? PHP_INT_MAX : $stop,
            'step'  => $step,
        ];
    }

    public static function enumerate($iterable, $start = 0)
    {
        $n = $start;

        foreach (self::iter($iterable) as $value) {
            yield [$n, $value];
            $n++;
        }
    }

    public static function iter($var)
    {
        switch (true) {
            case $var instanceof \Iterator:
                return $var;

            case $var instanceof \Traversable:
                return new \IteratorIterator($var);

            case is_string($var):
                $var = str_split($var);
                /* проваливаемся */

            case is_array($var):
                return new \ArrayIterator($var);

            default:
                $type = gettype($var);
                throw new \InvalidArgumentException("'$type' type is not iterable");
        }
    }

    public static function xrange($start_or_stop, $stop = PHP_INT_MAX, $step = 1)
    {
        $args = self::slice(...func_get_args());

        if ($args->step == 0) {
            throw new \InvalidArgumentException('xrange() arg 3 must not be zero');
        }

        if ($args->start > $args->stop && $args->step > 0 || $args->start < $args->stop && $args->step < 0) {
            return;
        }

        for ($i = $args->start; $i != $args->stop; $i += $args->step) {
            yield $i;
        }
    }

    public static function chain(...$iterables)
    {
        foreach ($iterables as $it) {
            foreach (self::iter($it) as $element) {
                yield $element;
            }
        }
    }

    public static function from_iterable($iterables)
    {
        foreach (self::iter($iterables) as $it) {
            foreach (self::iter($it) as $element) {
                yield $element;
            }
        }
    }

    public static function combinations($iterable, $r)
    {
        $pool = is_array($iterable) ? $iterable : iterator_to_array(self::iter($iterable));
        $n = sizeof($pool);

        if ($r > $n) {
            return;
        }

        $indices = range(0, $r - 1);
        yield array_slice($pool, 0, $r);

        for (;;) {
            for (;;) {
                for ($i = $r - 1; $i >= 0; $i--) {
                    if ($indices[$i] != $i + $n - $r) {
                        break 2;
                    }
                }

                return;
            }

            $indices[$i]++;

            for ($j = $i + 1; $j < $r; $j++) {
                $indices[$j] = $indices[$j - 1] + 1;
            }

            $row = [];
            foreach ($indices as $i) {
                $row[] = $pool[$i];
            }

            yield $row;
        }
    }

    public static function combinations_with_replacement($iterable, $r)
    {
        $pool = is_array($iterable) ? $iterable : iterator_to_array(self::iter($iterable));
        $n = sizeof($pool);

        if (!$n && $r) {
            return;
        }

        $indices = array_fill(0, $r, 0);
        yield array_slice($pool, 0, $r);

        for (;;) {
            for (;;) {
                for ($i = $r - 1; $i >= 0; $i--) {
                    if ($indices[$i] != $n - 1) {
                        break 2;
                    }
                }

                return;
            }

            array_splice($indices, $i, sizeof($indices), array_fill(0, $r - $i, $indices[$i] + 1));

            $row = [];
            foreach ($indices as $i) {
                $row[] = $pool[$i];
            }

            yield $row;
        }
    }

    public static function compress($data, $selectors)
    {
        foreach (self::izip($data, $selectors) as list($d, $s)) {
            if ($s) {
                yield $d;
            }
        }
    }

    public static function count($start = 0, $step = 1)
    {
        for ($i = $start;; $i += $step) {
            yield $i;
        }
    }

    public static function cycle($iterable)
    {
        return new \InfiniteIterator(self::iter($iterable));
    }

    public static function dropwhile(callable $predicate, $iterable)
    {
        $iterable = self::iter($iterable);

        foreach ($iterable as $x) {
            if (!$predicate($x)) {
                yield $x;
                break;
            }
        }

        foreach ($iterable as $x) {
            yield $x;
        }
    }

    public static function groupby($it, callable $keyfunc = null)
    {
        $it = self::iter($it);
        $tgtkey = $currkey = $currvalue = (object) [];

        $grouper = function ($tgtkey) use (&$currkey, &$currvalue, $keyfunc, $it) {
            while ($currkey == $tgtkey) {
                yield $currvalue;

                if (!$it->valid()) {
                    return;
                }

                $currvalue = $it->current();
                $it->next();

                $currkey = $keyfunc === null ? $currvalue : $keyfunc($currvalue);
            }
        };

        for (;;) {
            while ($currkey === $tgtkey) {
                if (!$it->valid()) {
                    return;
                }

                $currvalue = $it->current();
                $it->next();

                $currkey = $keyfunc === null ? $currvalue : $keyfunc($currvalue);
            }

            $tgtkey = $currkey;

            yield [$currkey, $grouper($tgtkey)];
        }
    }

    public static function ifilter(callable $predicate = null, $iterable)
    {
        if ($predicate === null) {
            $predicate = 'boolval';
        }

        foreach (self::iter($iterable) as $x) {
            if ($predicate($x)) {
                yield $x;
            }
        }
    }

    public static function ifilterfalse(callable $predicate = null, $iterable)
    {
        if ($predicate === null) {
            $predicate = 'boolval';
        }

        foreach (self::iter($iterable) as $x) {
            if (!$predicate($x)) {
                yield $x;
            }
        }
    }

    public static function imap(callable $function = null, ...$iterables)
    {
        foreach (self::izip(...$iterables) as $args) {
            if ($function === null) {
                yield $args;
            } else {
                yield $function(...$args);
            }
        }
    }

    public static function islice($iterable, ...$args)
    {
        if (self::slice(...$args)->step < 1) {
            throw new \InvalidArgumentException('Step for islice() must be a positive integer or null.');
        }

        $it = self::xrange(...$args);
        if ($it->valid()) {
            $nexti = $it->current();

            foreach (self::enumerate($iterable) as list($i, $element)) {
                if ($i === $nexti) {
                    yield $element;

                    $it->next();
                    if (!$it->valid()) {
                        break;
                    }

                    $nexti = $it->current();
                }
            }
        }
    }

    public static function izip(...$iterables)
    {
        $multipleIterator = new \MultipleIterator();
        foreach ($iterables as $iterable) {
            $multipleIterator->attachIterator(self::iter($iterable));
        }

        return $multipleIterator;
    }

    public static function izip_longest(/* ...$iterables[, $fillvalue] */ ...$args)
    {
        $fillvalue = array_pop($args);
        $counter   = sizeof($args);
        $iterables = array_map('iter', $args);

        $sentinel = function () use (&$counter, $fillvalue) {
            $counter--;
            yield $fillvalue;
        };

        $fillers = self::repeat($fillvalue);

        $iterators = array_map(function ($it) use ($sentinel, $fillers) {
            return self::chain($it, $sentinel(), $fillers);
        }, $iterables);

        for (;;) {
            $row = [];
            foreach ($iterators as $iterator) {
                if (!$iterator->valid()) {
                    return;
                }

                $row[] = $iterator->current();
                $iterator->next();
            }

            yield $row;

            if (!$counter) {
                return;
            }
        }
    }

    /**
     * 迭代组合
     *
     * @param string|array $iterable 迭代的内容
     * @param null $length 长度(不填写默认为迭代内容的长度)
     * @return \Generator|void
     */
    static function permutations($iterable, $length = null)
    {
//        $pool = is_array($iterable) ? $iterable : iterator_to_array(self::iter($iterable));
        $pool = Str::split($iterable);
        $n = sizeof($pool);

        $r = $length === null ? $n : $length;

        if ($r > $n) {
            return;
        }

        $indices = range(0, $n - 1);
        $cycles  = range($n, $n - $r - 1, -1);

        yield array_slice($pool, 0, $r);

        while ($n) {
            for (;;) {
                for ($i = $r - 1; $i >= 0; $i--) {
                    $cycles[$i]--;

                    if ($cycles[$i] === 0) {
                        $indices[] = array_splice($indices, $i, 1)[0];
                        $cycles[$i] = $n - $i;
                    } else {
                        $j = $cycles[$i];
                        $minus_j = sizeof($indices) - $j;

                        list($indices[$i], $indices[$minus_j]) = [$indices[$minus_j], $indices[$i]];

                        $row = [];
                        for ($i = 0; $i < $r; $i++) {
                            $row[] = $pool[$indices[$i]];
                        }

                        yield $row;
                        break 2;
                    }
                }

                return;
            }
        }
    }

    public static function product(/*...$iterables[, $repeat]*/ ...$args)
    {
        $repeat = array_pop($args);
        $iterables = array_map('iter', $args);

        $pools = array_merge(...array_fill(0, $repeat, $iterables));
        $result = [[]];

        foreach ($pools as $pool) {
            $result_inner = [];

            foreach ($result as $x) {
                foreach ($pool as $y) {
                    $result_inner[] = array_merge($x, [$y]);
                }
            }

            $result = $result_inner;
        }

        foreach ($result as $prod) {
            yield $prod;
        }
    }

    public static function repeat($object, $times = null)
    {
        if ($times === null) {
            for (;;) {
                yield $object;
            }
        } else {
            for ($i = 0; $i < $times; $i++) {
                yield $object;
            }
        }
    }

    public static function starmap(callable $function, $iterable)
    {
        foreach (self::iter($iterable) as $args) {
            yield $function(...$args);
        }
    }

    public static function takewhile(callable $predicate, $iterable)
    {
        foreach (self::iter($iterable) as $x) {
            if ($predicate($x)) {
                yield $x;
            } else {
                break;
            }
        }
    }

    public static function tee($iterable, $n = 2)
    {
        $it = new \CachingIterator(self::iter($iterable), \CachingIterator::FULL_CACHE);
        $result = [$it];

        for ($i = 1; $i < $n; $i++) {
            $result[] = call_user_func(function () use ($it) {
                foreach ($it->getCache() as $key => $value) {
                    yield $key => $value;
                }
            });
        }

        return $result;
    }
}
