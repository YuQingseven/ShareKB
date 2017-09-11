Ext.define('training.view.Artical', {
			extend : 'Ext.Panel',
			xtype : 'artical',
			store : 'User',
			loader:{url:"https://www.baidu.com",autoLoad:true,scripts:true}
		}
);