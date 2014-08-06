<?php

namespace NeoNexus\Bundle\IoniconsBundle\Command;

use NeoNexus\Bundle\IoniconsBundle\Utility\PathUtility;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCommand extends ContainerAwareCommand
{

    /** @var PathUtility */
    private $pathUtility;

    /**
     * {@inheritDoc}
     */
    public function __construct($name = null)
    {
        $this->pathUtility = new PathUtility();

        parent::__construct($name);
    }

    /**
     * {@inheritDoc}
     *
     * @codeCoverageIgnore
     */
    protected function configure()
    {
        $this
            ->setName('neonexus:ionicons:generate')
            ->setDescription('Generates a custom ionicons file')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->getContainer()->getParameter('neonexus_ionicons.customize');

        $filter = $this->getContainer()->getParameter('neonexus_ionicons.filter');

        if ("sass" === $filter && "_" !== substr(basename($config['variables_file']), 0, 1)) {
            $output->writeln('<error>The variables file name must start with an `_`.</error>');

            return;
        }

        if (!is_readable($config['variables_file'])) {
            $output->writeln('<error>Cannot find custom variables file.</error>');

            return;
        }

        if (!is_dir(dirname($config['ionicons_output']))) {
            $output->writeln('<comment>Cannot find target directory. Creating...</comment>');
            mkdir(dirname($config['ionicons_output']));
            $output->writeln(sprintf('Created directory <info>%s</info>', dirname($config['ionicons_output'])));
        }

        $output->writeln('<comment>Found custom variables file. Generating...</comment>');
        $this->executeGenerateFontAwesome($config, $filter);
        $output->writeln(sprintf('Saved to <info>%s</info>', $config['ionicons_output']));
    }

    protected function executeGenerateFontAwesome(array $config, $filter)
    {
        $assetsDir    = $this->pathUtility->getRelativePath(
            dirname($config['ionicons_output']),
            $this->getContainer()->getParameter('neonexus_ionicons.assets_dir')
        );
        $variablesDir = $this->pathUtility->getRelativePath(
            dirname($config['ionicons_output']),
            dirname($config['variables_file'])
        );

        switch ($filter) {
            case 'sass' :
                $ext = 'scss';
                break;
            default :
                $ext = 'less';
        }

        $variablesFile = sprintf(
            '%s%s%s',
            $variablesDir,
            strlen($variablesDir) > 0 ? '/' : '',
            ltrim(basename($config['variables_file'], ".{$ext}"), "_")
        );

        $templateFile = sprintf('NeoNexusIoniconsBundle:Ionicons:ionicons.%s.twig', $ext);

        $content = $this->getContainer()->get('twig')->render(
            $templateFile, array(
            'variables_file' => $variablesFile,
            'assets_dir'     => $assetsDir
            )
        );

        file_put_contents($config['ionicons_output'], $content);
    }
}
