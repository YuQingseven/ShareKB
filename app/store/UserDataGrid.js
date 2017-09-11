Ext.define('training.store.UserDataGrid', {
			extend : 'Ext.data.Store',
			requires : ['Ext.data.proxy.LocalStorage'],
			// fields: ['id','name', 'age','sex'],
			model : 'training.model.CanDataGrid'
			
		});