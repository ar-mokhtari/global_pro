<?php 

namespace app\modules\Codnitive\Template\blocks;

class Breadcrumbs 
{
    protected $_module = 'template';
    protected $_currentClass = 'fz-25';
    protected $_prevClass = '';
    protected $_nextClass = 'circle';
    protected $_breadcrumbs = [];

    public function getBreadcrumbs(string $current): array
    {
        foreach ($this->_breadcrumbs as $key => &$config) {
            $config['class'] = $this->_prevClass;
            if ($current == $key) {
                $config['class'] = $this->_currentClass;
                $this->_prevClass = $this->_nextClass;
            }
            $config['title'] = __($this->_module, $config['title']);
        }
        return $this->_breadcrumbs;
    }
}
