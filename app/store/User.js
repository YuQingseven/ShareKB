Ext.define('training.store.User', {
			extend : 'Ext.data.Store',
			requires : ['Ext.data.proxy.LocalStorage'],
			// fields: ['id','name', 'age','sex'],
			model : 'training.model.Can'
		});