Ext.define('training.view.DataGrid', {
			extend : 'Ext.grid.Panel',
			xtype : 'hsgrid',
			store : 'UserDataGrid',
			columns : [{
				flex:2,
					text : '日期',
					height : 35,
					dataIndex : 'date',
                                        renderer:Ext.util.Format.dateRenderer('Y-m-d H:i:s')
				},
				{
					flex:1.5,
					text : 'IP',
					height : 35,
					dataIndex : 'ip'
				},
			
				{
						flex:6,
						text : '评论内容',
						height : 35,
						dataIndex : 'comName',
						renderer:function(value,meta,record){
							//meta.style='overflow:auto;padding:3px 6px;text-overflow:ellipsis;white-space:nowrap;white-space:normal;line-height:20px;';
							meta.style='white-space:normal;word-break:break-all';
							return value;
						}
					}],
			selModel : {
				mode : 'MULTI'
			}

		});
