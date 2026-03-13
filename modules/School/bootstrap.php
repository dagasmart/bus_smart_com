<?php

use DagaSmart\BizAdmin\Admin;

$body = amis()->Page()->body([
    amis()
        ->Service()
        //->ws(['url' => 'ws://127.0.0.1:8080/app/awh2qmrjbmohoeqdtmuz', 'data' =>['event' => 'pusher:subscribe', 'data' => ['auth' => 'abc', 'channel' => 'channel-pub']]])
        ->api(admin_url('/system/message/badge/count'))
        ->interval(random_int(5000,6000))
        ->silentPolling()
        ->messages('连接失败，请检查网络')
        ->showErrorMsg(false)
        ->body([
            amis()->Icon()
                //->icon('iconfont icon-bell')
                ->icon('bell')
                ->vendor('iconfont')
                ->className('text-xl mr-3 ${blink}')
                ->badge(['mode' => 'text', 'position' => 'top-left', 'text' => '${(data && DECODEJSON(data).message.count) || count || 0}'])
                ->onEvent([
                    'click' => [
                        'actions' => [
                            amis()
                                ->DrawerAction()
                                ->drawer(
                                    amis()
                                        ->Drawer()
                                        ->closeOnEsc()
                                        ->closeOnOutside()
                                        ->showCloseButton(false)
                                        ->title(false)
                                        ->id('admin_message_drawer')
                                        ->resizable(false)
                                        ->headerClassName(false)
                                        ->bodyClassName('p-1 overflow-hidden')
                                        ->actions()
                                        ->body([
                                            amis()->Service()
                                                ->api(admin_url('/system/message/badge/data'))
                                                ->interval(5000)
                                                ->silentPolling()
                                                ->showErrorMsg(false)
                                                ->body([
                                                    amis()
                                                        ->Tabs()
                                                        ->draggable()
                                                        ->tabsMode('line')
                                                        ->tabs([
                                                            // 系统通知
                                                            amis()->Tab()
                                                                ->title([
                                                                    amis()->Container()->body([
                                                                        amis()->Tpl()->tpl('系统')->badge([
                                                                            'mode' => 'text',
                                                                            'text' => '${badge_system_count || 0}',
                                                                            'visibleOn' => '${badge_system_count > 0}',
                                                                        ]),
                                                                    ])
                                                                ])
                                                                ->icon('iconfont icon-official-notice')
                                                                ->body([
                                                                    amis()->ButtonToolbar()->buttons([
                                                                        amis()->AjaxAction()
                                                                            ->api('delete:/system/message/system/all')
                                                                            ->reload('admin_message_system')
                                                                            ->label('全部已读')
                                                                            ->size('xs')
                                                                            ->onEvent([
                                                                                'click' => [
                                                                                    'actions' => [
                                                                                        [
                                                                                            'actionType' => 'selectAll',
                                                                                            'componentId' => 'admin_message_system',
                                                                                        ]
                                                                                    ]
                                                                                ]
                                                                            ]),
                                                                    ]),
                                                                    amis()->Page()
                                                                        ->style(['padding'=>'none','height' => 'calc(100vh - 160px)', 'overflow-x' => 'hidden'])
                                                                        ->className('rounded-xl border-0 border-solid')
                                                                        ->body([
                                                                            amis()->CRUD2List()
                                                                                ->id('admin_message_system')
                                                                                ->source('${tabs_system}')
                                                                                ->api(admin_url('/system/message/list/system'))
                                                                                ->interval(5000)
                                                                                ->silentPolling()
                                                                                ->className('border-0')
                                                                                ->perPage(10)
                                                                                ->listItem([
                                                                                    'title' => '${title}',
                                                                                    'subTitle' => '${from_name} / ${updated_at}',
                                                                                    'desc' => '<h5>${simplify}</h5>',
                                                                                    'actions' => [
                                                                                        amis()->AjaxAction()
                                                                                            ->label('✕')
                                                                                            ->api('delete:/system/message/${id}')
                                                                                            ->reload('admin_message_system')
                                                                                            ->isolateScope()
                                                                                            ->style(['zoom' => 0.7])
                                                                                            ->onEvent([
                                                                                                'click' => [
                                                                                                    'actions' => [
                                                                                                        [
                                                                                                            'actionType' => 'setValue',
                                                                                                            'componentId' => 'admin_message_drawer',
                                                                                                            'args' => [
                                                                                                                'value' => [
                                                                                                                    'admin_message_drawer_system_count' => '${admin_message_drawer_system_count > 0 ? (admin_message_drawer_system_count - 1) : 0}',
                                                                                                                ]
                                                                                                            ]
                                                                                                        ]
                                                                                                    ]
                                                                                                ],
                                                                                            ]),

                                                                                    ],
                                                                                ]),
                                                                        ]),
                                                                ]),
                                                            // 站内信
                                                            amis()->Tab()
                                                                ->title([
                                                                    amis()->Container()->body([
                                                                        amis()->Tpl()->tpl('站内信')->badge([
                                                                            'mode' => 'text',
                                                                            'text' => '${badge_private_count}',
                                                                            'visibleOn' => '${badge_private_count > 0}',
                                                                        ]),
                                                                    ])
                                                                ])
                                                                ->icon('iconfont icon-message-queue')
                                                                ->body([
                                                                    amis()->ButtonToolbar()->buttons([
                                                                        amis()->Action()->label('选中项设为已读')->size('xs'),
                                                                    ]),
                                                                    amis()->Page()
                                                                        ->style(['padding'=>'none','height' => 'calc(100vh - 160px)', 'overflow-x' => 'hidden'])
                                                                        ->className('rounded-xl border-0 border-solid')
                                                                        ->body([
                                                                            amis()->CRUD2List()
                                                                                ->id('admin_message_private')
                                                                                ->source('${tabs_private}')
                                                                                ->api(admin_url('/system/message/list/private'))
                                                                                ->interval(5000)
                                                                                ->silentPolling()
                                                                                ->className('text-secondary')
                                                                                ->perPage(10)
                                                                                ->listItem([
                                                                                    'title' => '${title}',
                                                                                    'subTitle' => '${from_name} / ${updated_at}',
                                                                                    'desc' => '<h5>${simplify}</h5>',
                                                                                    'actions' => [
                                                                                        amis()->AjaxAction()
                                                                                            ->label('✕')
                                                                                            ->api('delete:/system/message/${id}')
                                                                                            ->style(['zoom' => 0.7])
                                                                                            ->reload('admin_message_private'),
        //                                                                                amis()->ButtonGroup()
        //                                                                                    ->buttons([
        //                                                                                        amis()->Button()->label('详情')->size('xs'),
        //                                                                                        amis()->Button()->label('打开')->level('primary')->size('xs'),
        //                                                                                    ])
        //                                                                                    ->btnLevel('light')
        //                                                                                    ->btnActiveLevel('primary')
        //                                                                                    ->vertical(),
                                                                                    ],
                                                                                ]),
                                                                        ]),
                                                                ]),

                                                            // 聊天
                                                            amis()->Tab()
                                                                ->title([
                                                                    amis()->Container()->body([
                                                                        amis()->Tpl()->tpl('聊天')->badge(['mode' => 'text', 'text' => 25]),
                                                                    ])
                                                                ])
                                                                ->icon('iconfont icon-header-message')
                                                                ->body([

                                                                ])
                                                        ])->toolbar([
                                                            amis()->SwitchControl('bell')
                                                                ->onText(amis()->Icon()->icon('bell'))
                                                                ->offText(amis()->Icon()->icon('bell'))
                                                                ->style(['zoom' => 0.7])
                                                                ->loadingOn('${isBell}')
                                                                ->onEvent([
                                                                    'change' => [
                                                                        'actions' => [
                                                                            [
                                                                                'actionType' => 'setValue',
                                                                                'componentId' => 'admin_message_drawer',
                                                                                'args' => [
                                                                                    'value' => [
                                                                                        'isBell' => true
                                                                                    ]
                                                                                ]
                                                                            ],
                                                                            [
                                                                                'actionType' => 'ajax',
                                                                                'api' => [
                                                                                    'method' => 'post',
                                                                                    'url' => '/system/message/bell',
                                                                                    'data' => [
                                                                                        'bell' => '${value}'
                                                                                    ],
                                                                                    'silent' => true,
                                                                                    'messages' => [
                                                                                        'success' => '成功',
                                                                                        'failed' => '失败',
                                                                                    ]
                                                                                ],
                                                                                'ignoreError' => true,
                                                                            ],
                                                                            [
                                                                                'actionType' => 'setValue',
                                                                                'componentId' => 'admin_message_drawer',
                                                                                'args' => [
                                                                                    'value' => [
                                                                                        'isBell' => false
                                                                                    ]
                                                                                ]
                                                                            ],
                                                                        ]
                                                                    ]
                                                                ]),

                                                        ])
                                            ])
                                        ])
                                )
                        ]

                    ]
                ]),
        ]),
]);

//$body = amis()->Service()
//    ->ws([
//        'url' => "ws://127.0.0.1:8876",
//        'body' => [
//            'token' => '${LOCAL_STORAGE.authToken}'
//        ],
//    ])
//    ->messages('连接失败，请检查网络')
//    ->body([
//        amis()->Tpl()->tpl('${data}'),
//    ]);
// 追加到已有按钮前
Admin::prependNav($body);
