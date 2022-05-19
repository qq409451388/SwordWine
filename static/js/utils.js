function createTable(response){
    var tableIniter = {
        headers:{},
        data:[],
        style:{
            table:{
                width:'auto',
                height:'auto',
                border:'1px solid #cdcdcd',
                fontWeight:'normal',
                marginTop:'20px'
            },
            th:{
                fontSize:'20px',
                fontWeight:'bold',
                width:'auto',
                height:'auto',
            },
            td:{
                fontSize:'16px',
                fontWeight:'normal',
                textAlign:'center'
            }
        },
        //1.初始化表格数据
        init:function(headers,data,style){
            try{
                if(headers != null){
                    this.headers = headers;
                }
                if(data != null){
                    this.data = data;
                }
                if(style != null){
                    this.style = style;
                }
            }catch(e){
                console.error(e);
            }
            console.log("init...");
            return this;
        },
        //2.显示数据
        show:function(id){
            try{
                if(id == null){
                    id = "content";
                    document.write("<div id='content'><div>");
                }
                var table = "";
                table += "<table style='margin-top:"+this.style.table.marginTop+";width:"+this.style.table.width+";height:"+this.style.table.height+";border:"+this.style.table.border+";font-weight:"+this.style.table.fontWeight+"'>";
                if(this.headers!=null){
                    table += "<tr>";
                    for(let header in this.headers){
                        table += "<th style='font-size:"+this.style.th.fontSize+";font-weight:"+this.style.th.fontWeight+";width:"+this.style.th.width+";height:"+this.style.th.height+"'>" + this.headers[header] + "</th>";
                    }
                    table += "</tr>";
                }
                if(this.data!=null){

                    for(let tr in this.data){
                        table += "<tr>";
                        for(let td in this.headers){
                            table += "<td style='font-size:"+this.style.td.fontSize+";font-weight:"+this.style.td.fontWeight+";text-align:"+this.style.td.textAlign+"'>" + this.data[tr][td] + "</td>";

                        }
                        table += "</tr>";
                    }

                }
                table += "</table>";
                document.getElementById(id).innerHTML = table;
                console.log("success!");
            }catch(e){
                console.error(e);
            }
        }
    };
    //初始化调用
    (function(){
        let headers = response.header;
        let data = response.list;
        let style;
        tableIniter.init(headers,data,style).show("content");
    })()
}

/**
 * innateHeaders 横向标题
 * dynamicHeaders 纵向标题
 * data           数据
 * style          css，key=>value mean to xx{key:value}
 *
 * Warning:innateHeaders.length must equals to data.length
 *
 * example when
 * response =>
 * [
 * "innateHeaders" => ["横向标题一","横向标题二","横向标题三","横向标题四"],
 * "dynamicHeaders" => ["纵向标题一", "纵向标题二"],
 * "data" => [
 *      [1,2],
 *      [3,4],
 *      [5,6],
 *      [7,8]
 * ]
 * ]
 * then generate table like this:
 * ——————————————————————————————————————————————
 * |cate    |横向标题一|横向标题二|横向标题三|横向标题四|
 * ——————————————————————————————————————————————
 * |纵向标题一|1       |3       |5       |7      |
 * ——————————————————————————————————————————————
 * |纵向标题二|2       |4       |6       |8      |
 * ——————————————————————————————————————————————
 * @param response
 */
function createTable2(response){
    let innerTable = {
        "innateHeaders":[],
        "dynamicHeaders":[],
        "data":[],
        "style":{
            "table":{},
            "th":{},
            "tr":{},
            "td":{}
        },
        init:function(innateHeaders, dynamicHeaders, data, style){
            try{
                if(!innateHeaders || !dynamicHeaders || !data){
                    return this;
                }
                if(innateHeaders.length !== data.length){
                    return this;
                }
                this.innateHeaders = innateHeaders;
                this.dynamicHeaders = dynamicHeaders;
                this.data = data;
                style = style || {};
                this.style.table = style.table|| {};
                this.style.th = style.th|| {};
                this.style.tr = style.tr|| {};
                this.style.td = style.td|| {};
                console.log(this);
                return this;
            }catch(e){
                console.log(e);
            }
        },
        buildStyle:function(cssData){
            if(Object.keys(cssData).length === 0){
                return "";
            }
            let style = "style='";
            for(k in cssData){
                style += k+":"+cssData[k]+";";
            }
            style += "'";
            return style;
        },
        show:function(nodeId){
            try{
                let tableInnerHtml = "";
                if(!!nodeId){
                    nodeId = "content";
                }
                let tableStyle = this.buildStyle(this.style.table);
                let trStyle = this.buildStyle(this.style.tr);
                let thStyle = this.buildStyle(this.style.th);
                let tdStyle = this.buildStyle(this.style.td);
                tableInnerHtml += "<table "+tableStyle+">";
                //1.build title
                tableInnerHtml += "<tr "+trStyle+"><th "+thStyle+">cate</th>";
                for(let key in this.innateHeaders){
                    tableInnerHtml += "<th "+thStyle+">"+this.innateHeaders[key]+"</th>";
                }
                tableInnerHtml += "</tr>";
                //2.build table body
                for(let key2 in this.dynamicHeaders){
                    tableInnerHtml += "<tr "+trStyle+"><td "+tdStyle+">"+this.dynamicHeaders[key2]+"</td>";
                    for(let key3 in this.data){
                        tableInnerHtml += "<td "+tdStyle+">"+(this.data[key3][key2] || 0)+"</td>";
                    }
                    tableInnerHtml += "</tr>";
                }
                tableInnerHtml += "</table>";
                let nodeContent = document.getElementById(nodeId);
                nodeContent.innerHTML = tableInnerHtml;
            }catch(e){
                console.log(e);
            }
        }

    };
    innerTable.init(response.innateHeaders, response.dynamicHeaders, response.data, response.style).show("content");
}

function http_build_query(url, params) {
    var urlLink = '';
    for(let key in params){
        urlLink += '&'+key+"="+params[key];
    }
    urlLink = url + "?" + urlLink.substr(1);
    return urlLink.replace(' ', '');
}

function get(url, params, callback, callbackfail = null){
    var ajax = new XMLHttpRequest();
    ajax.open('get', http_build_query(url, params));
    ajax.send();
    ajax.onreadystatechange = function () {
        if (ajax.readyState===4 && ajax.status===200) {
            let response = JSON.parse(ajax.responseText);
            callback(response);
        }else{
            callbackfail(ajax.responseText);
        }
    }
}

/**
 * 获取url的query部分
 * @param variable
 * @returns {string|boolean}
 */
function getQueryVariable(variable)
{
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i=0;i<vars.length;i++) {
        var pair = vars[i].split("=");
        if(pair[0] === variable){return pair[1];}
    }
    return null;
}

function setCookie(cname, cvalue, sec = 86400) {
    var d = new Date();
    d.setTime(d.getTime() + sec);
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(name)
{
    var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
    if(arr===document.cookie.match(reg))
        return unescape(arr[2]);
    else
        return null;
}