<?php

use DagaSmart\BizAdmin\Admin;

$body = amis()->Page()->body([
    amis()
        ->Service()
        ->ws(['url' => 'ws://127.0.0.1:8080/system/message/badge/data', 'data' => ['name' => '18']])
        ->api(admin_url('/system/message/badge/data'))
        ->messages('连接失败，请检查网络')
        ->body([
    amis()->Icon()
    ->icon('iconfont icon-bell')
    ->className('text-xl mr-3')
    ->style(['color'=>''])
    ->badge(['mode' => 'text', 'position' => 'top-left', 'text' => '${count || 0}'])
    ->onEvent([
        'click' => [
            'actions' => [
                amis()
                    ->DrawerAction()
                    ->drawer(
                        amis()
                            ->Drawer()
                            ->resizable(false)
                            ->closeOnEsc()
                            ->showCloseButton(false)
                            ->closeOnOutside()
                            ->title(false)
                            ->headerClassName(false)
                            ->bodyClassName('p-1 overflow-hidden')
                            ->actions()
                            ->body([
                                amis()
                                    ->Tabs()
                                    ->draggable()
                                    ->tabsMode('line')
                                    ->tabs([
                                        // 系统消息
                                        amis()->Tab()->title('系统消息')->body([
                                            amis()->ButtonToolbar()->buttons([
                                                amis()->Action()->label('已读选中项')->size('sm'),
                                            ]),
                                            amis()->Page()
                                                ->style(['padding'=>'none','height' => 'calc(100vh - 160px)', 'overflow-x' => 'hidden'])
                                                ->className('rounded-xl border-0 border-solid')
                                                ->body([

                                                    amis()->CRUD2List()
                                                        ->source('${tabs.system}')
                                                        ->className('text-secondary')
                                                        ->multiple(false)
                                                        ->selectable()
                                                        ->showSelection()
                                                        ->perPage(10)
                                                        ->listItem([
                                                            'title' => null,
                                                            'subTitle' => '${from_name} ${updated_at}',
                                                            'desc' => '<span class="text-current text-xs">${body}</span>',
                                                            'actions' => [
                                                                amis()->LinkAction()->label('详情')->link('/system/message')->size('xs'),
                                                            ],
                                                        ]),
                                                ]),
                                        ]),
                                        // 站内消息
                                        amis()->Tab()->title('站内消息')->body([
                                            amis()->Page()
                                                ->style(['padding'=>'none','height' => 'calc(100vh - 110px)', 'overflow' => 'hidden'])
                                                ->className('rounded-xl border-0 border-solid')
                                                ->body([
                                                    amis()->Card()
                                                        ->style(['height' => 'calc(100vh - 110px)'])
                                                        ->className('border-0 overflow-y-auto')
                                                        ->body([
                                                            amis()->GroupControl()->direction('vertical')->body([
                                                                amis()->Alert()
                                                                    ->level('warning')
                                                                    ->className('mb-3')
                                                                    ->showIcon()
                                                                    ->showCloseButton()
                                                                    ->title('标题')
                                                                    ->actions([
                                                                        amis()->button()
                                                                            ->label('查看详情')
                                                                            ->size('xs')
                                                                            ->level('link')
                                                                            ->style([
                                                                                'position'=>'relative',
                                                                                'top'=>'40px',
                                                                                'left'=>'30px'
                                                                            ])
                                                                    ])
                                                                    ->body(['创建成功']),

                                                                amis()->Alert()
                                                                    ->level('success')
                                                                    ->className('mb-3')
                                                                    ->showIcon()
                                                                    ->showCloseButton()
                                                                    ->title('标题')
                                                                    ->actions([
                                                                        amis()->button()
                                                                            ->label('查看详情')
                                                                            ->size('xs')
                                                                            ->level('link')
                                                                            ->style([
                                                                                'position'=>'relative',
                                                                                'top'=>'40px',
                                                                                'left'=>'30px'
                                                                            ])
                                                                    ])
                                                                    ->body(['创建成功']),

                                                                amis()->Alert()
                                                                    ->level('info')
                                                                    ->className('mb-3')
                                                                    ->showIcon()
                                                                    ->showCloseButton()
                                                                    ->title('标题')
                                                                    ->actions([
                                                                        amis()->button()
                                                                            ->label('查看详情')
                                                                            ->size('xs')
                                                                            ->level('link')
                                                                            ->style([
                                                                                'position'=>'relative',
                                                                                'top'=>'40px',
                                                                                'left'=>'30px'
                                                                            ])
                                                                    ])
                                                                    ->body(['创建成功']),

                                                                amis()->Alert()
                                                                    ->level('danger')
                                                                    ->className('mb-3')
                                                                    ->showIcon()
                                                                    ->icon('iconfont icon-duhome')
                                                                    ->showCloseButton()
                                                                    ->title('标题')
                                                                    ->actions([

                                                                        amis()->flex()
                                                                            ->justify('flex-start')
                                                                            ->alignItems('flex-start')
                                                                            ->direction('column')
                                                                            ->style(['padding'=>'6px'])
                                                                            ->items([
                                                                                amis()->button()
                                                                                    ->label('详情')
                                                                                    ->size('xs')
                                                                                    ->level('primary')
                                                                                    ->style([
                                                                                        'position'=>'relative',
                                                                                        'top'=>'30px',
                                                                                        'left'=>'30px'
                                                                                    ]),
                                                                            ])
                                                                    ])
                                                                    ->body(['创建成功']),

                                                                amis()->Alert()->className('bg-gray-50 border-gray-200 border-dashed shadow-md')->body('任务名称'),
                                                                amis()->Alert()->className('bg-gray-50 border-gray-200 border-dashed shadow-md')->body('任务名称'),
                                                                amis()->Alert()->className('bg-gray-50 border-gray-200 border-dashed shadow-md')->body('任务名称'),
                                                                amis()->Alert()->className('bg-gray-50 border-gray-200 border-dashed shadow-md')->body('任务名称'),
                                                                amis()->Alert()->className('bg-gray-50 border-gray-200 border-dashed shadow-md')->body('任务名称'),
                                                                amis()->Alert()->className('bg-gray-50 border-gray-200 border-dashed shadow-md')->body('任务名称'),
                                                            ]),
                                                        ]),
                                                ]),
                                        ]),
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
