Ext.define('training.controller.Main', {
    extend: 'Ext.app.Controller',
    views:['Viewport'],
	stores : ['User','UserDataGrid','UserRank'],
	models : ['Can','CanDataGrid','CanRank'],
    
    
    refs:[
    {
    	ref:'win',
    	autoCreate:true,
    	xtype:'hswin'//,
//    	selector:'hswin'
    },
    {
    	ref:'win1',
    	autoCreate:true,
    	xtype:'hswin1'//,
//    	selector:'hswin1'
    },
    {
    	ref:'rank',
    	autoCreate:true,
    	xtype:'rank'//,
//    	selector:'hswin'
    },
    {
    	ref:'btnCreate',
    	selector:'sgmenu button[name=create]'
    },
    {
    	ref:'btnEdit',
    	selector:'sgmenu button[name=edit]'
    },
    {
    	ref:'btnDelete',
    	selector:'sgmenu button[name=delete]'
    },
    {
    	ref:'btnPraise',
    	selector:'sgmenu button[name=praise]'
    }, 
    {
    	ref:'btndePraise',
    	selector:'sgmenu button[name=depraise]'
    },
    {
    	ref:'fm',
    	selector:'hswin form'
    },
    {
    	ref:'fm1',
    	selector:'hswin1 form'
    },
    {
    	ref:'fm2',
    	selector:'comtext form'
    },
    {
    	ref:'grid',
    	selector:'sgmenu'
    },
    {
    	ref:'grid1',
    	selector:'hsgrid'
    },
    {
    	ref:'nameText',
    	selector:'hswin textfield[name=userName]'
    },
    {
    	ref:'nameText1',
    	selector:'hswin1 textfield[name=userName]'
    },
    {
    	ref:'nameStart',
    	selector:'sgmenu datefield[name=start]'
    },
    {
    	ref:'nameStop',
    	selector:'sgmenu datefield[name=stop]'
    }
    
    ],
    init:function ()
    {
	this.control({
	'sgmenu button[name=rank]':{
    		click:function(){
    			//console.log(sel);
	    		var w1=this.getRank();
	    		//w1.isedit=true;
	        	w1.show();
	        	//w1.isedit=true;
				//this.getNameText1().readOnly=true;
    			//w1.show();
    			//this.getUserRankStore().load();
	        	//this.getFm1().loadRecord(sel[0]);
	        	//this.getFm1().loadRecord(sel[0]);
	        	//console.log(sel[0].data['userName']);
	        	//console.log(w1)
    		}
	},
	'sgmenu button[name=select]':{
	    	click:function(){
	    		//console.log(this.getNameStart().value);
	    		if(this.getNameStart().value!=null&&this.getNameStop().value!=null){
				if(isDate(this.getNameStart().rawValue)&&isDate(this.getNameStop().rawValue)){	
					if(this.getNameStart().value>this.getNameStop().value){
	    					alert('开始日期在截止日期之后，请重新输入！')
	    				}else if(this.getNameStart().value>new Date()){
	    					alert('开始日期在当前日期之后，请重新输入！')
	    				}else if(this.getNameStop().value>new Date().setDate(new Date().getDate()+1)){
	    					alert('截止日期在当前日期下一天之后，请重新输入！')
	    				}else{
	    					this.getUserStore().load({params:{ii:1,datestart:this.getNameStart().rawValue,datestop:this.getNameStop().rawValue}});
	    				}
				}else{
					alert('日期段输入不合法，请重新输入！');
				}
	    		}else if(this.getNameStart().value==null&&this.getNameStop().value==null){
	    			this.getUserStore().load({params:{ii:1}});
			}else if(this.getNameStart().value==null){
	    			alert('请输入开始日期!');
	    		}else{
	    			alert('请输入截止日期!');
	    		}
	    	}
	},
	'rank':{
		render:function(){
			this.getUserRankStore().load();
			//console.log(sel);
		}
	},
	'rank button[name=btn_cancel]' :{
		click : function () {
			this.getRank().close();
			//this.getUserStore().load({params:{ii:1}
			//});
		}
	},
	'comtext button[name=send]':{
	    	click:function(){
	    		var sel=this.getGrid().getSelectionModel().getSelection();
	    		if(sel.length==1){
		    		var fm=this.getFm2();
		    		//console.log(fm);
				if (!fm.isValid())
					return;
				var c=Ext.create('training.model.CanDataGrid');
				var store=this.getUserDataGridStore();
				c.data['shareId']=sel[0].data['shareId'];
				//c.data['ip']=tip[0].innerHTML;
				fm.updateRecord(c);
				if(c.data['comName']!=""){
					Ext.MessageBox.confirm('提示','评论内容是否提交？',function(btn){
						if(btn=='yes'){
						c.save(
						{
							success:function(){
								store.reload();
							},
							failure:function() {
								alert("新建失败!");
							},
							scope : this
						});
						//this.getUserDataGridStore().reload();
						}else{
						}
					});
				}else{
					alert("请输入评论内容!");
				}
				//this.getUserDataGridStore().reload();
	    		}else if(sel.length>1){
    				alert("请选择单条分享内容！");
    			}else{
    				alert("请选择一条分享内容！");
    			}
	    		
    		}
	    },
	    'actioncolumn#announcementGridActionEdit':{
	    	uppraise:function(record){
	    		//console.log(record);
	      		if(this.getNameStart().value!=null&&this.getNameStop().value!=null){
				if(isDate(this.getNameStart().rawValue)&&isDate(this.getNameStop().rawValue)){
                        		if(this.getNameStart().value>this.getNameStop().value){
                                		this.getUserStore().load({params:{praise:record.record.data['shareId']}});
					}else if(this.getNameStart().value>new Date()){
                             			this.getUserStore().load({params:{praise:record.record.data['shareId']}});
					}else if(this.getNameStop().value>new Date().setDate(new Date().getDate()+1)){
                              			this.getUserStore().load({params:{praise:record.record.data['shareId']}});
					}else{
                              		  	this.getUserStore().load({params:{praise:record.record.data['shareId'],datestart:this.getNameStart().rawValue,datestop:this.getNameStop().rawValue}});
					}
                 	      	}else{
                        	       	this.getUserStore().load({params:{praise:record.record.data['shareId']}});
				}
			}else{
				this.getUserStore().load({params:{praise:record.record.data['shareId']}});
			}		
	    		var store = this.getUserDataGridStore();
			//console.log(sel);
			//debugger;
			store.getProxy().setExtraParam("shareId", record.record.data['shareId']);
			store.load();
	    	},
	    	downpraise:function(record){
	    		//console.log(record.record.data['shareId']);
	    		if(this.getNameStart().value!=null&&this.getNameStop().value!=null){
                                if(isDate(this.getNameStart().rawValue)&&isDate(this.getNameStop().rawValue)){
                                        if(this.getNameStart().value>this.getNameStop().value){
                                       		this.getUserStore().load({params:{depraise:record.record.data['shareId']}});
					}else if(this.getNameStart().value>new Date()){
                               			this.getUserStore().load({params:{depraise:record.record.data['shareId']}});
					}else if(this.getNameStop().value>new Date().setDate(new Date().getDate()+1)){
                               			this.getUserStore().load({params:{depraise:record.record.data['shareId']}});
					}else{
                                                this.getUserStore().load({params:{depraise:record.record.data['shareId'],datestart:this.getNameStart().rawValue,datestop:this.getNameStop().rawValue}});
                                        }
                                }else{
                                        this.getUserStore().load({params:{depraise:record.record.data['shareId']}});
                                }
                        }else{
                                this.getUserStore().load({params:{depraise:record.record.data['shareId']}});
                        }
			var store = this.getUserDataGridStore();
			//console.log(sel);
			//debugger;
			store.getProxy().setExtraParam("shareId", record.record.data['shareId']);
			store.load();
	    	},
		uptread:function(record){
                        //console.log(record);
                        if(this.getNameStart().value!=null&&this.getNameStop().value!=null){
                                if(isDate(this.getNameStart().rawValue)&&isDate(this.getNameStop().rawValue)){
                                        if(this.getNameStart().value>this.getNameStop().value){
                                        	this.getUserStore().load({params:{tread:record.record.data['shareId']}});
				 	}else if(this.getNameStart().value>new Date()){
                                                this.getUserStore().load({params:{tread:record.record.data['shareId']}});
                                }else if(this.getNameStop().value>new Date().setDate(new Date().getDate()+1)){
                                                this.getUserStore().load({params:{tread:record.record.data['shareId']}});
                                }else{
                                                this.getUserStore().load({params:{tread:record.record.data['shareId'],datestart:this.getNameStart().rawValue,datestop:this.getNameStop().rawValue}});
                                        }
                                }else{
                                        this.getUserStore().load({params:{tread:record.record.data['shareId']}});
                                }
                        }else{
                                this.getUserStore().load({params:{tread:record.record.data['shareId']}});
                        }
			var store = this.getUserDataGridStore();
                        //console.log(sel);
                        //debugger;
                        store.getProxy().setExtraParam("shareId", record.record.data['shareId']);
                        store.load();
                },
                downtread:function(record){
                        //console.log(record.record.data['shareId']);
                        if(this.getNameStart().value!=null&&this.getNameStop().value!=null){
                                if(isDate(this.getNameStart().rawValue)&&isDate(this.getNameStop().rawValue)){
                                        if(this.getNameStart().value>this.getNameStop().value){
                                                this.getUserStore().load({params:{detread:record.record.data['shareId']}});
                                        }else if(this.getNameStart().value>new Date()){
                                                this.getUserStore().load({params:{detread:record.record.data['shareId']}});
                                }else if(this.getNameStop().value>new Date().setDate(new Date().getDate()+1)){
                                                this.getUserStore().load({params:{detread:record.record.data['shareId']}});
                                }else{
                                                this.getUserStore().load({params:{detread:record.record.data['shareId'],datestart:this.getNameStart().rawValue,datestop:this.getNameStop().rawValue}});
                                        }
                                }else{
                                        this.getUserStore().load({params:{detread:record.record.data['shareId']}});
                                }
                        }else{
                                this.getUserStore().load({params:{detread:record.record.data['shareId']}});
                        }
			var store = this.getUserDataGridStore();
                        //console.log(sel);
                        //debugger;
                        store.getProxy().setExtraParam("shareId", record.record.data['shareId']);
                        store.load();
                }
	    },
	    'sgmenu button[name=create]':{
    		click:function(){
    			//debugger;
    			var store = this.getUserStore();
			//console.log(sel);
			//debugger;
    			var w=this.getWin();
			w.isedit=true;	
    			w.show();
    			var b=this.getFm();
			var c=this.getNameStart();
			var d=this.getNameStop();
			store.load({
				params:{iii:1,start:0,limit:0},
				callback : function(records, operation, success){
					//debugger;				
					//console.log(store.data.items[0]);
					//console.log(records);
					dd=records[0];
					//dd.data['userName']='';
					//dd.data['headName']='';
					dd.data['urlName']='';
					//dd.data['tagName']='';
					b.loadRecord(dd);
					//records[0].data['userName']=dd[0];
					//console.log(success);
					if(c.value!=null&&d.value!=null){
                         	        	if(isDate(c.rawValue)&&isDate(d.rawValue)){
                                        		if(c.value>d.value){
                                                		store.load({params:{ii:1}});
                                        		}else if(c.value>new Date()){
                                                		store.load({params:{ii:1}});
                                			}else if(d.value>new Date().setDate(new Date().getDate()+1)){
                                                		store.load({params:{ii:1}});
                                			}else{
                                                		store.load({params:{ii:1,datestart:c.rawValue,datestop:d.rawValue}});
                                        		}
                                		}else{
                                        		store.load({params:{ii:1}});
                                		}
                        		}else{
                                		store.load({params:{ii:1}});
                        		}
				}
			});
			//console.log(store);
			//console.log(a);	
    		}
	},
    	'sgmenu button[name=edit]':{
    		click:function(){
    			var sel=this.getGrid().getSelectionModel().getSelection();
    			//console.log(sel);
    			if(sel.length==1){
    				if(sel[0].data['userName']!=''){
	    				var w1=this.getWin1();
	    				w1.isedit=true;
	    				this.getNameText1().readOnly=true;
	        			w1.show();
	        			this.getFm1().loadRecord(sel[0]);
	        			//this.getFm1().loadRecord(sel[0]);
	        			//console.log(sel[0].data['userName']);
	        			//console.log(w1)
    				}else{
    					alert("请新建一条分享信息或选择一条分享信息进行修改！");
    				}
    			}else if(sel.length>1){
    				alert("请选择单条分享内容！");
    			}else{
    				alert("请选择一条分享内容！");
    			}
    		}
		},
		'sgmenu button[name=delete]':{
			click:function(){
				var sel=this.getGrid().getSelectionModel().getSelection();
				if(sel.length>0){
					var store=this.getUserStore();
					var st = this.getGrid().getStore();
					//console.log(st);
					var nt = this.getGrid1().getStore();
					//console.log(nt);
					var ntt=nt.data.items;
					Ext.MessageBox.confirm('提示','确定要删除所选的分享信息吗？',function(btn){
						if(btn=='yes'){
							Ext.each(sel ,function (r)
							{
									//console.log(r);
								st.remove(r);
								//console.log(st);
							});
							st.sync();
							nt.remove(ntt);
							store.reload();
							//Ext.MessageBox.alert("提示","所选分享信息成功删除！");
						}else{
							//Ext.MessageBox.alert("提示","所选分享信息删除失败！");
						}
					});
				}else{
					alert('请选择需要删除的分享内容！');
				}
			}
		},
		'hswin button[name=btn_cancel]' :{
			click : function () {
					this.getWin().close();
				}
		},
		'hswin1 button[name=btn_cancel]' :{
			click : function () {
					this.getWin1().close();
				}
		},
		'hswin button[name=btn_ok]':{
			click:function (){
				var fm=this.getFm();
				
				if (!fm.isValid())
					return;
				var c=Ext.create('training.model.Can');
				fm.updateRecord(c);
				//console.log(c);
				c.save(
				{
						success:function(){
							this.getWin().close();
							
							this.getUserStore().reload();
						},
						failure:function() {
						alert("新建失败!");
						},
						scope : this
					});
				this.getWin().close();
				//this.getUserStore().load({params:{ii:1}
				//});
				
			}
		},
		'hswin1 button[name=btn_ok]':{
			click:function (){
				var fm=this.getFm1();
				//console.log(fm);
				if (!fm.isValid())
					return;
				fm.updateRecord();
				//console.log(fm);
				//console.log(fm);
				//console.log(this.getUserStore());
				//debugger;
				this.getUserStore().sync();
				
				//debugger;
				//this.getUserStore().commitChanges();
				this.getWin1().close();
				this.getUserStore().reload();
			}
		},
		'sgmenu':{
			render:function(){
				this.getUserStore().load({params:{ii:1}
				});
				
				//console.log(sel);
			},
			itemclick : function (self, record) {
				//var sel=this.getGrid().getSelectionModel().getSelection();
				//console.log(sel);
				var store = this.getUserDataGridStore();
				//console.log(sel);
				//debugger;
				store.getProxy().setExtraParam("shareId", record.data['shareId']);
				store.load();
				
				var url = record.get("urlName");
				var web = Ext.ComponentQuery.query("#webpage")[0];
				//console.log(web);
				web.update({
					autoEl : {
                                                tag : 'iframe',
                                                src : "http://www.baidu.com"
                                        }
				});
				web.getEl().el.dom.src = url;
			}
			/*itemdblclick : function (self, record) {
				var w=this.getWin();
				w.isedit=true;
				this.getNameText().readOnly=true;
				w.show();
				this.getFm().loadRecord(record);
			}*/
		}
		
		
			
		
	});
}
});
function isDate(str){  
	  //如果是正确的日期格式返回true,否则返回false  
	  var regExp;  
	  regExp = /\b\d{4}-\d{1,2}-\d{1,2}\b/;  
	    //判断整体格式yyyy-mm-dd  
	    if (str!=str.match(/\d{4}-\d{2}-\d{2}/ig))  {  
	       	//alert('请输入日期格式为：yyyy-mm-dd!');  
	        return false;  
	    }  
	  
	    var tmpArr;  
	    //tmpArr = str.split("-");  
	    tmpArr = str.split('-');  
	      
	    var rYear,rMonth,rDay  
	    rYear = parseInt(tmpArr[0]);  
	    rMonth = parseInt(tmpArr[1]);  
	    rDay = parseInt(tmpArr[2]);  
	    //判断月  
	    //if ((rMonth > 12) || (rMonth < 1))  {  
	    //  alert('月份输入错误!');  
	    //  return false;  
	    //}  
	  
	  var rYearflag;  
	  
	    //判断润年  
	    if (((rYear%100) == 0) && ((rYear%4) == 0)){  
	      rYearflag = true;  
	    }else if ((rYear%4) == 0){  
	      rYearflag = true;  
	    }else{  
	      rYearflag = false;  
	    }  
	  
	    if (((",1,3,5,7,8,10,12,").indexOf(","+rMonth+",") != -1) && (rDay < 32)){  
	      return(true);  
	    }   else if (((",4,6,9,11,").indexOf(","+rMonth+",") != -1) && (rDay < 31)){  
	      return(true);  
	    }else if (rDay < 29){  
	    return(true);  
	    }else if (rYearflag && (rDay < 30)){  
	    	return(true);  
	    }else {  
	    //alert('天输入错误!');  
	    	return false;  
	  }  
	}  

