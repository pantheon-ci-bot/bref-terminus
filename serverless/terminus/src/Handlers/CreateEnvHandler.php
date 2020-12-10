<?php declare(strict_types=1);

namespace Pantheon\Autopilot\Terminus\Handlers;

/**
 * Class CreateEnvHandler
 * @package Pantheon\Autopilot\Terminus\Handlers
 */
class CreateEnvHandler extends AbstractHandler
{
    /**
     * {@inheritdoc}
     *
     * The $event array must contain:
     *
     *   - 'site': The site name or site id of the target site.
     *   - 'source': The name of the source environment.
     *   - 'target': The name of the target environment.
     */
    public function validate(array $event): void
    {
        $this->checkRequiredEventParameters($event, ['site', 'source', 'target',]);
    }

    /**
     * {@inheritdoc}
     *
     * @see env:create for expected parameters in $event array.
     *
     * @return string
     * @throws \Pantheon\Terminus\Exceptions\TerminusException
     * @throws \Pantheon\Terminus\Exceptions\TerminusNotFoundException
     */
    public function action(array $event): string
    {
        $sites = $this->api->sites();
        $site = $sites->get($event['site']);
        $environments = $site->getEnvironments();
        $source_env = $environments->get($event['source']);
        $workflow = $environments->create($event['target'], $source_env);

        return $workflow->id;
    }
}
