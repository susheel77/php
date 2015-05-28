<?php
/**
 * 渲染类
 * 负责渲染骨架, 所有的pagelet
 * 将所有准备的数据, 填充到骨架中和所有的pagelet中
 * 将pagelet的html交给js去渲染到骨架中的div中去
 * @author zhanglei <zhanglei19881228@sina.com>
 * @date 2015-05-28 17:30
 */
class Render
{
    
    public function Render()
    {
        
    }
    
    public function getTemplate()
    {
        
    }
    
    public function pageStart()
    {
    
    }
    
    /**
     * 渲染页面, 包括骨架和pagelets
     * @param Pagelet $pagelet Pagelet类
     */
    public function renderPage(Pagelet $pagelet)
    {
        $tpl        = $pagelet->getTemplate();
        $skeleton   = $pagelet->getSkeleton();
        $data       = $pagelet->prepareData();
        extract($data);
    }
    
    public function flush()
    {
        
    }
    
    private function _sendJs()
    {
        
    }
    
}