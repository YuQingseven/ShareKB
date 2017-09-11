Ext.define('training.view.Viewport', {
	extend : 'Ext.container.Viewport',
	requires : ['Ext.layout.container.Fit', 'Ext.layout.container.Border',
			'training.view.Menu', 'training.view.Win','training.view.Win1','training.view.Rank',
			'training.view.DataGrid', 'training.view.ComText'],
	layout : {
		type : 'vbox',
		align : 'stretch'
	},

	items : [{
		height : 50,
		html : '技术分享平台',
		bodyStyle : 'color:#aaaaaa;padding:10px;font-size:30px;font-weight:bold;text-align:center'
	},	
	{
		flex:13,
		layout : {
			type : 'border',
			align : 'stretch'				
		},
		items:[{
			region:'west',
			flex:1,
			xtype : 'sgmenu',
			split:true,
			collapsible:true
		}, 
		{
			region:'center',
			flex:1,
			layout : {
				type : 'vbox',
				align : 'stretch'
			},
			items : [{
				xtype : 'component',
                                flex : 3,
                                itemId : "webpage",
                                autoEl : {
                                        id : "webpageid",
                                        tag : 'iframe',
                                        src : ""
                                	}
				}, 
				{
					xtype : 'hsgrid',
					flex:2
				},
				{
					xtype : 'comtext',
					height : 150
				}]
		}]
	},
	{
		height : 30,
        	html : '@forever 山石网科WebUI版权所有',
            	bodyStyle : 'color:#aaaaaa;padding:5px;font-size:13px;font-weight:bold;text-align:center'
	}]
});
