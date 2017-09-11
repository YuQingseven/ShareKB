Ext.define('training.model.CanRank',{	
	requires : ['Ext.data.proxy.LocalStorage'],
	extend : 'Ext.data.Model',
 	fields:[{name:'userRank',type:'int'},
 				  {name:'userName',type:'varchar'},
 				  {name:'amount',type:'int'}
 				  ],
 				  
	autoLoad: true,
	proxy : {
		type : 'ajax',
		api : {
			//create:'php/Rank.php?action=create',
			read:'php/Rank.php?action=read',
			//update:'php/Rank.php?action=update',
			//destroy:'php/Rank.php?action=destroy'
		}
	}
}
);

