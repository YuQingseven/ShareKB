Ext.define('training.view.ComText', {
			extend : 'Ext.form.FormPanel',
			xtype : 'comtext',
			store : 'UserDataGrid',
			title : '评论',
			layout : {
				type : 'fit'
			},
			bodyPadding : "15 10 0 15",
			border : false,
			padding : "0 0 5 0",	
			initComponent : function() {
				var fmm = Ext.create('Ext.form.Panel', {
					border : false,
							items : [
							{
								xtype : 'textareafield',
								labelWidth : 50,
								//width: 780,
								grow : true,
								allowBlank : true,
								name : 'comName',
								fieldLabel : '请输入',
								anchor : '100%'
								
									}]

						});

				this.items = [fmm];

				this.callParent();

			},
buttons : [{
				
				text : '发送',
				name : 'send'
			}]
		});
