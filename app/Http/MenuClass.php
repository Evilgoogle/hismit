<?php

namespace App\Http;

class MenuClass
{
    function getCat($categories)
    {
        $array = [];
        foreach ($categories as $menu){
            $array[$menu->id]['id'] = $menu->id;
            $array[$menu->id]['title'] = $menu->title;
            $array[$menu->id]['parent'] = $menu->parent;
            $array[$menu->id]['url'] = $menu->url;
//            $array[$menu->id]['image'] = $menu->image;
//            $array[$menu->id]['enable'] = $menu->enable;
        }
        
        return $array;
    }

    function getTree($dataset)
    {
        $tree = array();

        foreach ($dataset as $id => &$node) {
            if (isset($node['parent'])) {
                $dataset[$node['parent']]['childs'][$id] = &$node;
            } else {
                $tree[$id] = &$node;
            }
        }

        return $tree;
    }

    // Default Begin
    function createDefault($categories)
    {
        $cat = $this->getCat($categories);
        $tree = $this->getTree($cat);
        $cat_menu = $this->showDefault($tree);
        $categories = '<ul class="ul-menu">'. $cat_menu .'</ul>';

        return $categories;
    }

    function templateDefault($category)
    {
        $menu = '<li class="li-menu" data-id="'. $category['id'] .'" data-url="'. $category['url'] .'">';

        if (!empty($category['parent'])) {
            $menu .= '<a class="a-menu" href="/menu/'. $category['url'] .'" data-id="'. $category['id'] .'" data-url="'. $category['url'] .'"><span>'. $category['title'] .'</span></a>';
        } else {
            $menu .= '<div class="wrap-menu">';
//            $menu .= '<div class="wrap-img-menu"><img src="/uploads/'. $category['image'] .'" data-src="/uploads/'. $category['image'] .'"></div>';
            $menu .= '<div class="wrap-link-menu '. isset($category['childs']) ? '' : 'no-child' .'"><a class="a-menu" href="/menu/'. $category['url'] .'" data-id="'. $category['id'] .'" data-url="'. $category['url'] .'"><span>'. $category['title'] .'</span></a></div>';
            $menu .= '</div>';
            $menu .= '<div class="select"></div>';
        }

        if(isset($category['childs']))
            $menu .= '<ul class="ul-sub-menu">'. $this->showDefault($category['childs']) .'</ul>';

        $menu .= '</li>';

        return $menu;
    }

    function showDefault($data)
    {
        $string = '';
        foreach($data as $item){
            $string .= $this->templateDefault($item);
        }
        
        return $string;
    }
    // Default End

    // Selector Start
    function createSelector($categories, $categories_id)
    {
        $cat = $this->getCat($categories);
        $tree = $this->getTree($cat);
        $cat_menu = $this->showSelector($tree, '', $categories_id);

        return $cat_menu;
    }

    function templateSelector($category, $str, $categories_id)
    {
        $menu = '';
        if (empty($category['parent'])) {
            if (in_array($category['id'], $categories_id)) {
                $menu = '<option selected disabled>Выберите категорию</option>';
                $menu .= '<option value="/menu/'. $category['url'] .'">'. $category['title'] .'</option>';
            }
        } else {
            if (in_array($category['id'], $categories_id))
                $menu = '<option value="/menu/'. $category['url'] .'">'. $str .' '. $category['title'] .'</option>';
        }

        if(isset($category['childs'])){
            $i = 1;
            for($j = 0; $j < $i; $j++){
                $str .= '→';
            }
            $i++;

            $menu .= $this->showSelector($category['childs'], $str, $categories_id);
        }

        return $menu;
    }

    function showSelector($data, $str, $menu_id)
    {
        $string = '';
        foreach($data as $item){
            $string .= $this->templateSelector($item, $str, $menu_id);
        }

        return $string;
    }

    // Admin Selector Start
    function createAdmin($categories, $menu_id = null)
    {
        $cat = $this->getCat($categories);
        $tree = $this->getTree($cat);
        $cat_menu = $this->showAdmin($tree, '', $menu_id);

        return $cat_menu;
    }

    function templateAdmin($category, $str, $category_id)
    {
        if (!empty($category['parent']) && isset($category['parent'])) {
            $menu = '<option value="'. $category['id'] .'"';
            if ($category['id'] == $category_id)
                $menu .= ' selected';
            $menu .= '>'. $str .' '. $category['title'] .' ('. $category['id'] .')</option>';
        } else {
            $menu = '<option value="'. $category['id'] .'"';
            if ($category['id'] == $category_id)
                $menu .= ' selected';
            $menu .= '>'. $category['title'] .' ('. $category['id'] .')</option>';
        }

        if (isset($category['childs'])) {
            $i = 1;
            for($j = 0; $j < $i; $j++){
                $str .= '→';
            }
            $i++;

            $menu .= $this->showAdmin($category['childs'], $str, $category_id);
        }

        return $menu;
    }

    function showAdmin($data, $str, $menu_id)
    {
        $string = '';
        foreach($data as $item) {
            $string .= $this->templateAdmin($item, $str, $menu_id);
        }

        return $string;
    }
    // Admin Selector End
}