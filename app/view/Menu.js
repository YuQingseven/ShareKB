Ext.define('training.view.Menu', {

			extend: 'Ext.grid.Panel',
			requires:['Ext.selection.CheckboxModel','training.view.DataGrid','training.view.Rank'],
			xtype : 'sgmenu',
			selType:'checkboxmodel',
			store : 'User',
			autoScroll:true,
			title : "分享信息：",
			layout : {
				type : "vbox"
			},
			dockedItems:[{
				xtype:'toolbar',
				dock:'top',
				items:[{
						text : '新建',
						name : 'create'
					}, {
						text : '编辑',
						name : 'edit'
					}, {
						text : '删除',
						name : 'delete'
					},"->",
					{
						text : '分享数量排名',
						name : 'rank'
				}]
			},{
				xtype:'toolbar',
				dock:'top',
				items:["->",{
			        flex:7,
					xtype: 'datefield',
			        anchor: '100%',
			        fieldLabel: '开始日期',
			        name: 'start',
			        format: 'Y-m-d',
			    }, {
			    	flex:7,
			    	xtype: 'datefield',
			        anchor: '100%',
			        fieldLabel: '截止日期',
			        name: 'stop',
			        format: 'Y-m-d',
			    },{
			    	flex:1.2,
			    	text : '查询',
					name : 'select'
			    }]
			}
			   ]
			,
			buttonAlign : 'center',
			initComponent : function() {
				
				this.columns = [
						{
							flex :1 ,
							header : '日期',
							dataIndex : 'date',
                                                        renderer:Ext.util.Format.dateRenderer('Y-m-d H:i:s')
						}, 
						{
							flex : 0.6,
							header : '分享人',
							dataIndex : 'userName',
							align:'center'
						}, 
						{
							flex : 0.9,
							header : '标题',
							dataIndex : 'headName',
							renderer:function(value,metaData,record,rowIndex,colIndex,store){
								//console.log(record);
									//var row=grid.getSelectionModel().selectRow(startrow);
									//var rownum=grid.getSelectionModel().getSelected();
								
								var str=record.data['urlName'].substring(0,4);
								//console.log(str);
								if(str!='http'){
									record.data['urlName']="http://"+record.data['urlName'];
									//console.log(value);
									return "<a style='white-space:normal;word-break:break-all' href='"+record.data['urlName']+"' target='_Blank'>"+value+"</a>";
								}else{
									return "<a style='white-space:normal;word-break:break-all' href='"+record.data['urlName']+"' target='_Blank'>"+value+"</a>";
								}
							}
						}, 
						{
							flex : 0.9,
							header : 'Tags',
							dataIndex : 'tagName',
							renderer:function(value,meta,record){
								//meta.style='overflow:auto;padding:3px 6px;text-overflow:ellipsis;white-space:nowrap;white-space:normal;line-height:20px;';
								meta.style='white-space:normal;word-break:break-all';
								return value;
							}
						},
						{
							flex : 0.4,
							header : '赞/踩',
							dataIndex : 'voteUp',
							align:'center',
							renderer:function(value,meta,record){
								if(record.data['voteUp']==""){
									return '';
								}else{
									return record.data['voteUp']+'/'+record.data['voteDown'];
								}
							}
						},
						{
							xtype:'actioncolumn',
							flex : 0.5,
							align:'center',
							id:'announcementGridActionEdit',
							items: [{  
									icon : 'fig/up.png',  
									
									tooltip: '点个赞',
									getClass:function(v,meta,r,record){
										//console.log(r.get('isPraise'));
										if(r.get('isPraise')==1||r.get('isPraise')==2){
											return 'x-hidden';
										}else{
											return 'doc_lines';
										}
									}, 
									handler: function(grid, rowIndex, colIndex, item) {  
										var rec = grid.getStore().getAt(rowIndex);  
										this.fireEvent('uppraise', {  
								    		record: rec  
								    	});  
									}  
								},
								{  
									icon : 'fig/upDisable.png',  
									tooltip: '点错了',
									getClass:function(v,meta,r,record){
										//console.log(r.get('isPraise'));
										if(r.get('isPraise')==0||r.get('isPraise')==2){
											return 'x-hidden';
										}else{
											return 'doc_lines';
										}
									},
									handler: function(grid, rowIndex, colIndex, item) {  
										var rec = grid.getStore().getAt(rowIndex);  
										this.fireEvent('downpraise', {  
											record: rec  
										});  
									}
								  },
								  {  
                                                                        icon : 'fig/down.png',  
                                                                        tooltip: '点个踩',
                                                                        getClass:function(v,meta,r,record){
                                                                                //console.log(r.get('isPraise'));
                                                                                if(r.get('isTread')==1||r.get('isTread')==2){
                                                                                        return 'x-hidden';
                                                                                }else{
                                                                                        return 'doc_lines';
                                                                                }
                                                                        }, 
                                                                        handler: function(grid, rowIndex, colIndex, item) {  
                                                                                var rec = grid.getStore().getAt(rowIndex);  
                                                                                this.fireEvent('uptread', {  
                                                                                record: rec  
                                                                        });  
                                                                        }  
                                                                },
								{
                                                                        icon : 'fig/downDisable.png',  
                                                                        tooltip: '点错了',
                                                                        getClass:function(v,meta,r,record){
                                                                                //console.log(r.get('isPraise'));
                                                                                if(r.get('isTread')==0||r.get('isTread')==2){
                                                                                        return 'x-hidden';
                                                                                }else{
                                                                                        return 'doc_lines';
                                                                                }
                                                                        },
                                                                        handler: function(grid, rowIndex, colIndex, item) {  
                                                                                var rec = grid.getStore().getAt(rowIndex);  
                                                                                this.fireEvent('downtread', {  
                                                                                        record: rec  
                                                                                });  
                                                                        }
                                                                }
								] ,
							text : '操作',
							//dataIndex : 'thumbsUp',
		
						}
				];
				this.bbar={
					xtype:'pagingtoolbar',
					store:'User',
					//pageSize:30,
					displayInfo:true,
					displayMsg:'显示{0}-{1}条，共{2}条',
					emptyMsg:"没有分享数据"
				};
				this.callParent(arguments);
			}
		}
);
