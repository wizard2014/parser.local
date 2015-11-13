<?php

namespace Utility\Extension;

use Twig_Extension;

class Md5 extends Twig_Extension {
    /**
     * @return string
     */
    public function getName() {
        return 'md5';
    }

    /**
     * {@inheritdoc}
     */
    public function getTests()
    {
        return [
            new \Twig_SimpleTest('md5', [$this, 'md5'])
        ];
    }

    /**
     * @return array
     */
    public function getFilters() {
        return [
            'md5' => new \Twig_Filter_Method($this, 'md5', [
                'needs_environment' => true,
                'needs_context' => true,
                'is_safe' => [
                    'md5' => true
                ],
            ])
        ];
    }

    /**
     * @param \Twig_Environment $environment
     * @param                   $context
     * @param                   $string
     *
     * @return string
     */
    public function md5(\Twig_Environment $environment, $context, $string) {
        $loader = $environment->getLoader();
        $environment->setLoader($loader);

        return md5($string);
    }
}
