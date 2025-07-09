<header class="header border-b border-gray-200 dark:border-gray-700">
                        <div class="header-wrapper h-16">
                            <!-- Header Nav Start start-->
                            <div class="header-action header-action-start">
                                <div id="side-nav-toggle"
                                    class="side-nav-toggle header-action-item header-action-item-hoverable">
                                    <div class="text-2xl">
                                        <svg class="side-nav-toggle-icon-expand" stroke="currentColor" fill="none"
                                            stroke-width="0" viewBox="0 0 24 24" height="1em" width="1em"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6h16M4 12h16M4 18h7"></path>
                                        </svg>
                                        <svg class="side-nav-toggle-icon-collapsed hidden" stroke="currentColor"
                                            fill="none" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"
                                            height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 6h16M4 12h16M4 18h16"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="side-nav-toggle-mobile header-action-item header-action-item-hoverable"
                                    data-bs-toggle="modal" data-bs-target="#mobile-nav-drawer">
                                    <div class="text-2xl">
                                        <svg stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24"
                                            height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6h16M4 12h16M4 18h7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="header-search header-action-item header-action-item-hoverable text-2xl"
                                    data-bs-toggle="modal" data-bs-target="#dialog-search">
                                </div>
                            </div>
                            <!-- Header Nav Start end-->
                            <!-- Header Nav End start -->
                            <div class="header-action header-action-end">
                                <!-- Config-->
                                <div class="text-2xl header-action-item header-action-item-hoverable"
                                    data-bs-toggle="modal" data-bs-target="#nav-config">
                                    <svg stroke="currentColor" fill="none" stroke-width="0" viewBox="0 0 24 24"
                                        height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>


                            </div>
                            <!-- Header Nav End end -->
                        </div>
                    </header>
                    <!-- Popup start -->
                    <div class="modal fade" id="nav-config" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog drawer drawer-end">
                            <div class="drawer-content">
                                <div class="drawer-header">
                                    <h4>Theme Config</h4>
                                    <span class="close-btn close-btn-default" role="button" data-bs-dismiss="modal">
                                        <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                            viewBox="0 0 20 20" height="1em" width="1em"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                </div>
                                <div class="drawer-body">
                                    <div class="flex flex-col h-full justify-between">
                                        <div class="flex flex-col gap-y-10 mb-6">
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h6>Dark Mode</h6>
                                                    <span>Switch theme to dark mode</span>
                                                </div>
                                                <div>
                                                    <label class="switcher">
                                                        <input name="dark-mode-toggle" type="checkbox" value="">
                                                        <span class="switcher-toggle"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <div>
                                                    <h6>Direction</h6>
                                                    <span>Select a direction</span>
                                                </div>
                                                <div class="input-group">
                                                    <button id="dir-ltr-button"
                                                        class="btn btn-default btn-sm btn-active">
                                                        LTR
                                                    </button>
                                                    <button id="dir-rtl-button"
                                                        class="btn bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 active:bg-gray-100 dark:active:bg-gray-500 dark:active:border-gray-500 text-gray-600 dark:text-gray-100 radius-round h-9 px-3 py-2 text-sm">
                                                        RTL
                                                    </button>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-3">Nav Mode</h6>
                                                <div class="inline-flex">
                                                    <label class="radio-label inline-flex mr-3"
                                                        for="nav-mode-radio-default">
                                                        <input id="nav-mode-radio-default" type="radio" value="default"
                                                            name="nav-mode-radio-group" class="radio text-primary-600"
                                                            checked>
                                                        <span>Default</span>
                                                    </label>
                                                    <label class="radio-label inline-flex mr-3"
                                                        for="nav-mode-radio-themed">
                                                        <input id="nav-mode-radio-themed" type="radio" value="themed"
                                                            name="nav-mode-radio-group" class="radio text-primary-600">
                                                        <span>Themed</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="mb-3">Nav Mode</h6>
                                                <select id="theme-select"
                                                    class="input input-sm focus:ring-primary-600 focus-within:ring-primary-600 focus-within:border-primary-600 focus:border-primary-600">
                                                    <option value="primary" selected>Indigo</option>
                                                    <option value="red">Red</option>
                                                    <option value="orange">Orange</option>
                                                    <option value="amber">Amber</option>
                                                    <option value="yellow">Yellow</option>
                                                    <option value="lime">Lime</option>
                                                    <option value="green">Green</option>
                                                    <option value="emerald">Emerald</option>
                                                    <option value="teal">Teal</option>
                                                    <option value="cyan">Cyan</option>
                                                    <option value="sky">Sky</option>
                                                    <option value="blue">Blue</option>
                                                    <option value="violet">Violet</option>
                                                    <option value="purple">Purple</option>
                                                    <option value="fuchsia">Fuchsia</option>
                                                    <option value="pink">Pink</option>
                                                    <option value="rose">Rose</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>