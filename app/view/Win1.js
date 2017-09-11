Ext.define('training.view.Win1', {
	extend : 'Ext.window.Window',
	requires : ['Ext.form.Panel', 'Ext.form.FormPanel'],
	xtype : 'hswin1',
	store : 'User',
	closable:false,
	autoHeight:true,
	title : '分享内容修改',
	buttons : [{
				text : '确定',
				name : 'btn_ok'
			}, {
				text : '取消',
				name : 'btn_cancel'
			}],
	buttonAlign : 'center',
	initComponent : function() {
		var required = '<span style="color:red;font-weight:bold" data-qtip="Required">*</span>';
		var required1 = '<span style="color:red;font-weight:bold" data-qtip="Required">每个Tag用空格分开！</span>';
		var fmm = Ext.create('Ext.form.Panel', {
				bodyPadding : 15,	
				defaults : {
						xtype : 'textfield',
						labelWidth : 80
					},
					items : [
							{
								name : 'userName',
								afterLabelTextTpl : required,
								allowBlank : false,
								width:300,
								fieldLabel : '分享人'
							}, {
								name : 'headName',
								afterLabelTextTpl : required,
								allowBlank : false,
								width:300,
								fieldLabel : '标题'
							}, {
								name : 'urlName',
								afterLabelTextTpl : required,
								allowBlank : false,
								width:300,
								fieldLabel : 'url'
							}, {
								name : 'tagName',
								afterLabelTextTpl : required1,
								allowBlank : true,
								width:300,
								fieldLabel : 'Tags'
							},{
                                                                xtype:'textareafield',
                                                                name : 'tag',
                                                                //autoSize:'left',
                                                                //wordWrap:true,
                                                                //condenseWrite:true,
                                                                //multiline:true,
                                                                disabled:true,
                                                                grow : true,
                                                                width:300,
                                                                fieldLabel : 'Tag参考'
                                                        }]

				});

		this.items = [fmm];

		this.callParent();

	}

});
