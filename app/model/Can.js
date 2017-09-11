Ext.define('training.model.Can',{
	requires : ['Ext.data.proxy.LocalStorage'],
	extend : 'Ext.data.Model',
 	fields:[{name:'shareId',type:'int'},
 			{name:'userName',type:'varchar'},
 			{name:'headName',type:'varchar'},
 			{name:'urlName',type:'varchar'},
 			{name:'tagName',type:'varchar'},
 			{name:'voteUp'},
			{name:'voteDown'},
 			{name:'date',type:'date',dateFormat:'Y-m-d H:i:s'},
 			{name:'tag',type:'varchar'},
			{name:'isPraise'},
			{name:'isTread'},
 		],	
 		autoLoad: true,
		//pageSize: 30,
		proxy : {
			type : 'ajax',
			api : {
				create:'php/myphp.php?action=create',
    				read:'php/myphp.php?action=read',
    				update:'php/myphp.php?action=update',
    				destroy:'php/myphp.php?action=destroy'
			},
			reader:{
				type:'json',
				root:'data',
				totalProperty:'total'
			},
			//baseParams:{start:0,limit:30}
		}
});
