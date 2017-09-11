Ext.define('training.store.UserRank', {			
			extend : 'Ext.data.Store',
			uses : ['Ext.data.proxy.LocalStorage'],
			// fields: ['id','name', 'age','sex'],
			model : 'training.model.CanRank'
		});
