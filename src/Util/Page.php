<?php

namespace Webguosai\Util;

/**
 * 分页类
 * @author  xiaojiong & 290747680@qq.com
 * @date 2011-08-17
 *
 * show(2)  1 ... 62 63 64 65 66 67 68 ... 150
 * 分页样式
 * #page{font:12px/16px arial}
 * #page span{float:left;margin:0px 3px;}
 * #page a{float:left;margin:0 3px;border:1px solid #ddd;padding:3px 7px; text-decoration:none;color:#666}
 * #page a.now_page,#page a:hover{color:#fff;background:#05c}
*/
class Page
{
    public     $first_row;           //起始行数

    public     $list_rows;        //列表每页显示行数

    protected  $total_pages;      //总页数

    protected  $total_rows;          //总行数

    protected  $now_page;         //当前页数

    protected  $is_ajax  = FALSE; //是否ajax

    protected  $parameter = '';

    protected  $page_name;        //分页参数的名称

    protected  $ajax_func_name;

    public        $plus = 3;         //分页偏移量

    protected  $url;


    /**
     * 构造函数
     * @param array $data
     */
    public function __construct($data = array())
    {
        $this->total_rows = $data['total_rows'];

        $this->parameter  = !empty($data['parameter']) ? $data['parameter'] : '';
        //$this->list_rows  = !empty($data['list_rows']) && $data['list_rows'] <= 100 ? $data['list_rows'] : 15;
        $this->list_rows  = !empty($data['list_rows']) ? $data['list_rows'] : 15;
        $this->total_pages= ceil($this->total_rows / $this->list_rows);
        $this->page_name  = !empty($data['page_name']) ? $data['page_name'] : 'p';

        /* 当前页面 */
        if(!empty($data['now_page']))
        {
            $this->now_page = intval($data['now_page']);
        }else{
            $this->now_page   = !empty($_GET[$this->page_name]) ? intval($_GET[$this->page_name]):1;
        }
        $this->now_page   = $this->now_page <= 0 ? 1 : $this->now_page;


        if(!empty($data['is_ajax']))
        {
            $this->is_ajax = TRUE;
            $this->ajax_func_name = $data['ajax_func_name'];
        }

        if(!empty($this->total_pages) && $this->now_page > $this->total_pages)
        {
            $this->now_page = $this->total_pages;
        }
        $this->first_row = $this->list_rows * ($this->now_page - 1);
    }

    /**
     * 得到当前连接
     * @param $page
     * @param $text
     * @return string
     */
    protected function _get_link($page,$text)
    {
        if($this->is_ajax)
        {
            $parameter = '';
            if($this->parameter)
            {
                $parameter = ','.$this->parameter;
            }
            return '<a onclick="' . $this->ajax_func_name . '(\'' . $page . '\''.$parameter.')" href="javascript:void(0)">' . $text . '</a>';
        }
        else
        {
            return '<a href="' . $this->_get_url($page) . '">' . $text . '</a>';
        }
    }


    /**
     * 设置当前页面链接
     */
    protected function _set_url()
    {
        $url  =  $_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'':"?").$this->parameter;
        $parse = parse_url($url);
        if(isset($parse['query'])) {
            parse_str($parse['query'],$params);
            unset($params[$this->page_name]);
            $url   =  $parse['path'].'?'.http_build_query($params);
        }
        if(!empty($params))
        {
            $url .= '&';
        }
        $this->url = $url;
    }

    /**
     * 得到$page的url
     * @param mixed $page 页面
     * @return string
     */
    protected function _get_url($page)
    {
        if($this->url === NULL)
        {
            $this->_set_url();
        }
      //    $lable = strpos('&', $this->url) === FALSE ? '' : '&';
        return $this->url . $this->page_name . '=' . $page;
    }


    /**
     * 得到第一页
     * @param string $name
     * @return string
     */
    public function first_page($name = '第一页')
    {
         if($this->now_page > 5)
         {
             return $this->_get_link('1', $name);
         }
         return '';
    }

    /**
     * 最后一页
     * @param $name
     * @return string
     */
    public function last_page($name = '最后一页')
    {
         if($this->now_page < $this->total_pages - 5)
         {
             return $this->_get_link($this->total_pages, $name);
         }
         return '';
    }

    /**
     * 上一页
     * @param string $name
     * @return string
     */
    public function up_page($name = '上一页')
    {
        if($this->now_page != 1)
        {
            return $this->_get_link($this->now_page - 1, $name);
        }
        return '';
    }

    /**
     * 下一页
     * @param string $name
     * @return string
     */
    public function down_page($name = '下一页')
    {
        if($this->now_page < $this->total_pages)
        {
            return $this->_get_link($this->now_page + 1, $name);
        }
        return '';
    }

    /**
     * 分页样式输出
     * @param $param
     * @return string
     */
    public function show($param = 1)
    {
        if($this->total_rows < 1)
        {
            return '';
        }
        switch ($param) {
            case '1' :
                return $this->show_1();
                break;
            case '2' :
                return $this->show_2();
                break;
            case '3' :
                $this->ajax_func_name  = empty($this->ajax_func_name) ? 'toPage' : $this->ajax_func_name;
                return $this->show_3();
                break;
        }
    }

    protected function show_2()
    {
        if($this->total_pages != 1)
        {
            $return = '';
            $return .= $this->up_page('<');
            for($i = 1;$i<=$this->total_pages;$i++)
            {
                if($i == $this->now_page)
                {
                    $return .= "<a class='now_page'>$i</a>";
                }
                else
                {
                    if($this->now_page-$i>=4 && $i != 1)
                    {
                        $return .="<span class='pageMore'>...</span>";
                        $i = $this->now_page-3;
                    }
                    else
                    {
                        if($i >= $this->now_page+5 && $i != $this->total_pages)
                        {
                            $return .="<span>...</span>";
                            $i = $this->total_pages;
                        }
                        $return .= $this->_get_link($i, $i);
                    }
                }
            }
            $return .= $this->down_page('>');
            return $return;
        }
    }

    protected function show_1()
    {
        $plus = $this->plus;
        if( $plus + $this->now_page > $this->total_pages)
        {
            $begin = $this->total_pages - $plus * 2;
        }else{
            $begin = $this->now_page - $plus;
        }

        $begin = ($begin >= 1) ? $begin : 1;
        $return = '<a class="now_page page_total" data-num="'.$this->total_rows.'">共'.$this->total_rows.'条</a>';
        $return .= $this->first_page();
        $return .= $this->up_page();
        for ($i = $begin; $i <= $begin + $plus * 2;$i++)
        {
            if($i>$this->total_pages)
            {
                break;
            }
            if($i == $this->now_page)
            {
                $return .= "<a class='now_page'>$i</a>";
            }
            else
            {
                $return .= $this->_get_link($i, $i);
            }
        }
        $return .= $this->down_page();
        $return .= $this->last_page();
        return $return;
    }

    protected function show_3()
    {
        $plus = $this->plus;
        if( $plus + $this->now_page > $this->total_pages)
        {
            $begin = $this->total_pages - $plus * 2;
        }else{
            $begin = $this->now_page - $plus;
        }
        $begin = ($begin >= 1) ? $begin : 1;
        $return = '总计 ' .$this->total_rows. ' 个记录分为 ' .$this->total_pages. ' 页, 当前第 ' . $this->now_page . ' 页 ';
        $return .= ',每页 ';
        $return .= '<input type="text" value="'.$this->list_rows.'" id="pageSize" size="3"> ';
        $return .= $this->first_page();
        $return .= $this->up_page();
        $return .= $this->down_page();
        $return .= $this->last_page();
        $return .= '<select onchange="'.$this->ajax_func_name.'(this.value)" id="gotoPage">';

        for ($i = $begin;$i<=$begin+10;$i++)
        {
            if($i>$this->total_pages)
            {
                break;
            }
            if($i == $this->now_page)
            {
                $return .= '<option selected="true" value="'.$i.'">'.$i.'</option>';
            }
            else
            {
                $return .= '<option value="' .$i. '">' .$i. '</option>';
            }
        }
         $return .= '</select>';
        return $return;
    }
}
