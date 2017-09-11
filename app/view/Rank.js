Ext.define('training.view.Rank', {	
	extend : 'Ext.window.Window',
	//requires : ['Ext.grid.Panel'],
	xtype : 'rank',
	
	closable:false,
	layout:'fit',
	width : 400,
	height : 400,
	title : '分享数量排名',
	
	buttons : [{
		text : '关闭',
		name : 'btn_cancel'

	}],
	bodyStyle : 'padding:35px',
	buttonAlign : 'right',
	initComponent : function() {
		var fmm = Ext.create('Ext.grid.Panel', {
			autoScroll:true,
			store:'UserRank',
			//items : [{
			//xtype:'grid',
			columns : [
				{
					flex:0.5,
					text : '排名',
					//height : 35,
					dataIndex : 'userRank',
					//renderer:Ext.util.Format.dateRenderer('Y-m-d H:m:s')
				},
				{
					flex:2,
					text : '分享人',
					//height : 35,
					dataIndex : 'userName',
					//renderer:Ext.util.Format.dateRenderer('Y-m-d H:m:s')
				},
				{
					flex:1,
					text : '分享数量',
					//height : 35,
					dataIndex : 'amount',
					align:'right'
				}]
						//}]
	
			});
		//fmm.getStore().load({callback:function(records, operation, success){
		//	//debugger;
		//}});
		this.items = [fmm];

		this.callParent();

	}

	

});


