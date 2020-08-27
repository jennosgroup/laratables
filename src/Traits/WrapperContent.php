<?php

namespace Laratables\Traits;

trait WrapperContent
{
    /**
     * Indicate whether we should display the top wrapper top content view.
     */
    protected bool $shouldDisplayTopWrapperTopContentView = true;

    /**
     * Indicate whether we should display the top wrapper middle content view.
     */
    protected bool $shouldDisplayTopWrapperMiddleContentView = true;

    /**
     * Indicate whether we should display the top wrapper bottom content view.
     */
    protected bool $shouldDisplayTopWrapperBottomContentView = true;

    /**
     * Indicate whether we should display the bottom wrapper top content view.
     */
    protected bool $shouldDisplayBottomWrapperTopContentView = true;

    /**
     * Indicate whether we should display the bottom wrapper middle content view.
     */
    protected bool $shouldDisplayBottomWrapperMiddleContentView = true;

    /**
     * Indicate whether we should display the bottom wrapper bottom content view.
     */
    protected bool $shouldDisplayBottomWrapperBottomContentView = true;

    /**
     * Indicate whether we should display the top wrapper top content view.
     *
     * @return bool
     */
    public function shouldDisplayTopWrapperTopContentView(): bool
    {
        return $this->shouldDisplayTopWrapperTopContentView;
    }

    /**
     * Indicate whether we should display the top wrapper middle content view.
     *
     * @return bool
     */
    public function shouldDisplayTopWrapperMiddleContentView(): bool
    {
        return $this->shouldDisplayTopWrapperMiddleContentView;
    }

    /**
     * Indicate whether we should display the top wrapper bottom content view.
     *
     * @return bool
     */
    public function shouldDisplayTopWrapperBottomContentView(): bool
    {
        return $this->shouldDisplayTopWrapperBottomContentView;
    }

    /**
     * Indicate whether we should display the bottom wrapper top content view.
     *
     * @return bool
     */
    public function shouldDisplayBottomWrapperTopContentView(): bool
    {
        return $this->shouldDisplayBottomWrapperTopContentView;
    }

    /**
     * Indicate whether we should display the bottom wrapper middle content view.
     *
     * @return bool
     */
    public function shouldDisplayBottomWrapperMiddleContentView(): bool
    {
        return $this->shouldDisplayBottomWrapperMiddleContentView;
    }

    /**
     * Indicate whether we should display the bottom wrapper bottom content view.
     *
     * @return bool
     */
    public function shouldDisplayBottomWrapperBottomContentView(): bool
    {
        return $this->shouldDisplayBottomWrapperBottomContentView;
    }

    /**
     * Indicate whether the top wrapper top content has a view.
     *
     * @return bool
     */
    public function hasTopWrapperTopContentView(): bool
    {
        return method_exists($this, 'getTopWrapperTopContentView');
    }

    /**
     * Indicate whether the top wrapper middle content has a view.
     *
     * @return bool
     */
    public function hasTopWrapperMiddleContentView(): bool
    {
        return method_exists($this, 'getTopWrapperMiddleContentView');
    }

    /**
     * Indicate whether the top wrapper bottom content has a view.
     *
     * @return bool
     */
    public function hasTopWrapperBottomContentView(): bool
    {
        return method_exists($this, 'getTopWrapperBottomContentView');
    }

    /**
     * Indicate whether the bottom wrapper top content has a view.
     *
     * @return bool
     */
    public function hasBottomWrapperTopContentView(): bool
    {
        return method_exists($this, 'getBottomWrapperTopContentView');
    }

    /**
     * Indicate whether the bottom wrapper middle content has a view.
     *
     * @return bool
     */
    public function hasBottomWrapperMiddleContentView(): bool
    {
        return method_exists($this, 'getBottomWrapperMiddleContentView');
    }

    /**
     * Indicate whether the bottom wrapper bottom content has a view.
     *
     * @return bool
     */
    public function hasBottomWrapperBottomContentView(): bool
    {
        return method_exists($this, 'getBottomWrapperBottomContentView');
    }

    /**
     * The view for the top wrapper middle content.
     *
     * @return string
     */
    public function getTopWrapperMiddleContentView()
    {
        return 'laratables::templates.top-wrapper-middle-content';
    }

    /**
     * The view path for the bottom wrapper middle content.
     *
     * @return string
     */
    public function getBottomWrapperMiddleContentView()
    {
        return 'laratables::templates.bottom-wrapper-middle-content';
    }
}
