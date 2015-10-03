<?php

namespace PedroTroller\DreddReport\Bundle;

use PedroTroller\DreddReport\DependencyInjection\Compiler\JurorCreationPass;
use PedroTroller\DreddReport\DependencyInjection\DreddReportExtension;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Compiler\AddSecurityVotersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DreddReportBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new DreddReportExtension();
    }

    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new JurorCreationPass());
        $container->addCompilerPass(new AddSecurityVotersPass());
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return dirname(parent::getPath());
    }
    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        return substr(parent::getNamespace(), 0, strrpos(parent::getNamespace(), '\\'));
    }
}
