<?php namespace Core\Hook;

class HookProvider
{
    public static function register(HookAction $action): void
    {
        HooksRegistry::register($action);
    }

    public static function execute(string $hook, array $args = []): HookResultCollection
    {
        $collection = new HookResultCollection();
        $actions = HooksRegistry::getHookActions($hook);

        foreach ( $actions as $action ) {
            $collection->putItemIntoCollection($action->execute($args));
        }

        return $collection;
    }
}
