<?php

namespace Laratables\Traits;

trait Actions
{
    /**
     * If we should automatically handle the actions column.
     */
    protected bool $hasActions = false;

    /**
     * The title for the action column.
     */
    protected string $actionColumnTitle = 'Actions';

    /**
     * The action type.
     *
     * Accepts 'button' or 'link'.
     */
    protected string $actionDisplayType = 'link';

    /**
     * The type of content for the action.
     *
     * Accepts 'text' or 'icon'.
     */
    protected string $actionContentType = 'text';

    /**
     * The list of action types that is needed by default.
     *
     * Example:
     * 'view' => ['routeName' => 'users.show', 'method' => 'get'],
     * 'edit' => ['routeName' => 'users.edit', 'method' => 'get'],
     * 'delete' => ['routeName' => 'users.destroy', 'method' => 'delete'],
     */
    protected array $actions = [];

    /**
     * Check if we should use actions.
     *
     * @return bool
     */
    public function hasActions(): bool
    {
        return $this->hasActions;
    }

    /**
     * Get the action column title.
     *
     * NOTE:: As part of the standard functionality of this package, before
     * a column title is rendered, a check is made to see if there is a method
     * provided to over ride the default title. All we are doing here is taking
     * advantage of that functionality.
     *
     * @return string
     */
    public function getActionColumnTitle(): string
    {
        return $this->actionColumnTitle;
    }

    /**
     * Get the action type.
     *
     * @return string
     */
    public function getActionDisplayType(): string
    {
        return $this->actionDisplayType;
    }

    /**
     * Get the action content type.
     *
     * @return string
     */
    public function getActionContentType(): string
    {
        return $this->actionContentType;
    }

    /**
     * Get the actions.
     *
     * @return array
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * Get the action for an individual item.
     *
     * @param  mixed  $item
     *
     * @return array
     */
    public function getItemActions($item): array
    {
        return $this->getActions();
    }

    /**
     * Get the whitelist of query args to allow on the actions form submit.
     *
     * @param  string  $action
     *
     * @return array
     */
    public function getActionQueryParameters(string $action): array
    {
        $results = [];
        $whitelist = [];
        $blacklist = [];

        $globalWhitelistMethod = 'getActionQueryParametersWhitelist';
        $globalBlacklistMethod = 'getActionQueryParametersBlacklist';
        $whitelistMethod = 'get'.ucwords($action).'ActionQueryParametersWhitelist';
        $blacklistMethod = 'get'.ucwords($action).'ActionQueryParametersBlacklist';

        if (method_exists($this, $globalWhitelistMethod)) {
            $whitelist = $this->$globalWhitelistMethod($action);
        }

        if (method_exists($this, $whitelistMethod)) {
            $whitelist = array_merge($whitelist, $this->$whitelistMethod());
        }

        if (method_exists($this, $globalBlacklistMethod)) {
            $blacklist = $this->$globalBlacklistMethod($action);
        }

        if (method_exists($this, $blacklistMethod)) {
            $blacklist = array_merge($blacklist, $this->$blacklistMethod());
        }

        foreach ($this->getQueryParameters() as $key => $value) {
            if (in_array('*', $whitelist) || in_array($key, $whitelist)) {
                $results[$key] = $value;
                continue;
            }
            if (in_array('*', $blacklist)) {
                continue;
            }
            if (! in_array($key, $blacklist)) {
                $results[$key] = $value;
            }
        }

        // If the page key is requested and isn't in the $_GET attributes, add 1 as the default
        if (in_array($this->getPageKey(), $whitelist) && ! array_key_exists($this->getPageKey(), $results)) {
            $results[$this->getPageKey()] = 1;
        }

        return $results;
    }

    /**
     * Get the actions column content.
     *
     * NOTE:: As part of the standard functionality of this package, before
     * a column content is rendered, a check is made to see if there is a method
     * provided to over ride the default content. All we are doing here is taking
     * advantage of that functionality.
     *
     * @param  iterable  $item
     *
     * @return string
     */
    public function getActionsColumnContent($item)
    {
        $content = "<div ".$this->elementHtml('actions').">";

        foreach ($this->getItemActions($item) as $action => $data) {
            $options = [
                'route' => route($data['routeName'], $item),
                'method' => strtolower($data['method']),
                'table' => $this,
                'action' => $action,
            ];

            $content .= view('laratables::partials.action', $options);
        }

        $content .= "</div>";

        return $content;
    }

    /**
     * Get the action icon markup.
     *
     * @param  string  $action
     *
     * @return string|null
     */
    public function getActionIconMarkup(string $action): ?string
    {
        $method = 'get'.ucwords($action).'ActionIconMarkup';

        if (! method_exists($this, $method)) {
            return null;
        }

        return $this->$method();
    }

    /**
     * Get the action text.
     *
     * @param  string  $action
     *
     * @return string|null
     */
    public function getActionText(string $action): ?string
    {
        $method = 'get'.ucwords($action).'ActionText';

        if (! method_exists($this, $method)) {
            return null;
        }

        return $this->$method();
    }

    /**
     * Get the view action icon markup.
     *
     * @return string
     */
    public function getViewActionIconMarkup(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor" class="laratables-view-icon">
                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                <path fillRule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clipRule="evenodd" />
            </svg>';
    }

    /**
     * Get the edit action icon markup.
     *
     * @return string
     */
    public function getEditActionIconMarkup(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor" class="laratables-edit-icon">
            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
        </svg>';
    }

    /**
     * Get the trash action icon markup.
     *
     * @return string
     */
    public function getTrashActionIconMarkup(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor" class="laratables-trash-icon">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>';
    }

    /**
     * Get the restore action icon markup.
     *
     * @return string
     */
    public function getRestoreActionIconMarkup(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor" class="laratables-restore-icon">
            <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
            <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
        </svg>';
    }

    /**
     * Get the delete action icon markup.
     *
     * @return string
     */
    public function getDeleteActionIconMarkup(): string
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor" class="laratables-delete-icon">
            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>';
    }

    /**
     * Get the view action text.
     *
     * @return string
     */
    public function getViewActionText(): string
    {
        return 'View';
    }

    /**
     * Get the edit action text.
     *
     * @return string
     */
    public function getEditActionText(): string
    {
        return 'Edit';
    }

    /**
     * Get the trash action text.
     *
     * @return string
     */
    public function getTrashActionText(): string
    {
        return 'Trash';
    }

    /**
     * Get the restore action text.
     *
     * @return string
     */
    public function getRestoreActionText(): string
    {
        return 'Restore';
    }

    /**
     * Get the delete action text.
     *
     * @return string
     */
    public function getDeleteActionText(): string
    {
        return 'Delete';
    }
}
