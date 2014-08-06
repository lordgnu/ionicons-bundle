<?php

namespace NeoNexus\Bundle\IoniconsBundle\DependencyInjection;

/**
 * Description of AsseticConfiguration
 *
 * @author ernst
 */
class AsseticConfiguration
{

    public function build(array $config)
    {
        $output = array();

        if ('/' !== substr($config['output_dir'], -1) && strlen($config['output_dir']) > 0) {
            $config['output_dir'] .= '/';
        }

        switch ($config['filter']) {
            case 'none' :
                $output['ionicons_css'] = $this->copyCss($config);
                break;
            case 'less' :
                $output['ionicons_css'] = $this->buildWithLess($config);
                break;
            case 'sass' :
                $output['ionicons_css'] = $this->buildWithSass($config);
                break;
        }

        return $output;
    }

    protected function copyCss(array $config)
    {
        $inputs[] = $config['assets_dir'] . '/css/ionicons.css';

        return array(
            'inputs' => $inputs,
            'filters' => array(),
            'output' => $config['output_dir'] . 'css/ionicons.css'
        );
    }

    protected function buildWithLess(array $config)
    {
        $ioniconsFile = $config['assets_dir'] . '/less/ionicons.less';
        if (true === isset($config['customize']['variables_file']) &&
            null !== $config['customize']['variables_file']) {
            $ioniconsFile = $config['customize']['ionicons_output'];
        }

        $inputs = array(
            $ioniconsFile,
        );

        return array(
            'inputs' => $inputs,
            'filters' => array($config['filter']),
            'output' => $config['output_dir'] . 'css/ionicons.css'
        );
    }

    protected function buildWithSass(array $config)
    {
        $ioniconsFile = $config['assets_dir'] . '/scss/ionicons.scss';
        if (true === isset($config['customize']['variables_file']) &&
            null !== $config['customize']['variables_file']) {
            $ioniconsFile = $config['customize']['ionicons_output'];
        }

        $inputs = array(
            $ioniconsFile,
        );

        return array(
            'inputs' => $inputs,
            'filters' => array($config['filter']),
            'output' => $config['output_dir'] . 'css/ionicons.css'
        );
    }
}
