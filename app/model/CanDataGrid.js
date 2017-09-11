Ext.define('training.model.CanDataGrid',{
	requires : ['Ext.data.proxy.LocalStorage'],
	extend : 'Ext.data.Model',
 	fields:[{name:'comName',type:'varchar'},
 				  {name:'shareId',type:'int'},
 				  {name:'ip',type:'varchar'},
 				 {name:'date',type:'date',dateFormat:'Y-m-d H:i:s'}],
 				  
	autoLoad: true,
	proxy : {
		type : 'ajax',
		api : {
			create:'php/myphp1.php?action=create',
			read:'php/myphp1.php?action=read',
			update:'php/myphp.php?action=update',
			destroy:'php/myphp.php?action=destroy'
		}
	}
}
);
