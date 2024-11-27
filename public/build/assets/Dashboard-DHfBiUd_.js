import{k as p,l as K,m as M,p as Q,q as c,o as b,f as q,a as e,b as a,w as t,i as w,s as k,u as i,t as n,d as s,c as V,g as z,F as J,x as W,y as X,z as Y,A as Z,B as ee,C as te}from"./app-B0RD5qJU.js";import ae from"./Header-BREM8Kaf.js";import se from"./DocumentPieChart-BXW9uvvO.js";import le from"./ExamCycleBarChart-DCU_-HpM.js";import de from"./LineChart-I5gwVgzt.js";import{_ as oe}from"./_plugin-vue_export-helper-DlAUqK2U.js";import"./index-q5NytakN.js";const v=g=>(ee("data-v-35b1fd2d"),g=g(),te(),g),ce={id:"main",class:"main"},ne=Y('<div class="pagetitle" data-v-35b1fd2d><h1 data-v-35b1fd2d>Dashboard</h1><nav data-v-35b1fd2d><ol class="breadcrumb" data-v-35b1fd2d><li class="breadcrumb-item" data-v-35b1fd2d><a href="#" data-v-35b1fd2d>Home</a></li><li class="breadcrumb-item active" data-v-35b1fd2d>Dashboard</li></ol></nav></div>',1),re={style:{"font-weight":"bold","font-size":"48px",color:"#012970"}},ie=v(()=>a("br",null,null,-1)),ue=v(()=>a("br",null,null,-1)),me=v(()=>a("br",null,null,-1)),_e={style:{"font-weight":"bold","font-size":"48px",color:"#012970"}},fe=v(()=>a("br",null,null,-1)),he=v(()=>a("br",null,null,-1)),pe=v(()=>a("br",null,null,-1)),be=v(()=>a("th",{class:"text-left font-weight-bold text-primary"},"Exam Cycle",-1)),ve={class:"text-left font-weight-bold text-primary"},ge={class:"text-left font-weight-bold text-primary"},ye={class:"text-left font-weight-bold text-primary"},xe={class:"font-weight-bold text-green-darken-2"},we={class:"text-green-darken-2 text-center"},ke={class:"text-green-darken-2 text-center"},Ee={class:"text-green-darken-2 text-center"},Ce={__name:"Dashboard",props:{client:{type:Object,required:!0},admin:{type:Object,required:!0}},setup(g){const O=p(0),$=p(0),B=p([]);let E=p("Jun-2024");const G=p([]);let r=p(!0);const C=K();setTimeout(()=>{r.value=!1},3e3);const f=p({pendings:0,shipped:0,delivered:0,passed:0,failed:0}),N=p({pendings:0,shipped:0,delivered:0,passed:0,failed:0}),y=M({categories:[],series:[]});Q(()=>E.value,d=>{console.log("Selected Exam cycle is: ",d),A(d)});const H=async()=>{const l=await(await fetch("/dashboard/summary")).json();O.value=l.generatedDocs,$.value=l.students},L=async()=>{try{const d=await fetch("/dashboard/summary/stats"),{pendings:l,shipped:h,delivered:u,passed:m,failed:_}=await d.json();f.value={pendings:l,shipped:h,delivered:u,passed:m,failed:_},console.log("Summary Stats Data:",f.value)}catch(d){console.error("Error fetching data:",d),C.error("Error fetching data")}},A=d=>{Z.get("/dashboard/exam_cycle/stats",{params:{exam_cycle:d}}).then(l=>{const{pendings:h,shipped:u,delivered:m,passed:_,failed:o}=l.data;N.value={pendings:h,shipped:u,delivered:m,passed:_,failed:o},console.log("Exam Cycle DAta:",N.value)}).catch(l=>{console.error(l),C.error("Error fetching data")})},P=async()=>{try{const l=await(await fetch("/dashboard/exam_cycle/timeline")).json();y.categories=l.categories,y.series=l.series,G.value=l.table,console.log("Exam Cycle Timeline Data:",l)}catch(d){console.error("Error fetching exam cycle timeline data:",d),C.error("Error fetching exam cycle timeline data")}};return(async()=>{try{const l=await(await fetch("/dashboard/populateExamCycle")).json();B.value=l.exam_cycles,console.log("Exam Cycle Options:",B.value)}catch(d){console.error("Error fetching exam cycle options:",d),C.error("Error fetching exam cycle options:")}})(),H(),L(),A("Jun-2024"),P(),(d,l)=>{const h=c("v-icon"),u=c("v-card-title"),m=c("v-card-subtitle"),_=c("v-card-item"),o=c("v-col"),x=c("v-row"),I=c("v-card"),F=c("v-divider"),D=c("v-skeleton-loader"),j=c("v-sheet"),R=c("v-table"),U=c("v-select");return b(),q(J,null,[e(ae,{data:{client:g.client,admin:g.admin}},null,8,["data"]),a("main",ce,[ne,a("section",null,[a("div",null,[e(x,{class:"",align:"center",justify:"space-around"},{default:t(()=>[w(e(o,{cols:"12",md:"6"},{default:t(()=>[e(I,{title:"Documents Generated",class:"mx-auto card-shadow dashboard-card mb-5",subtitle:"Total no. of documents generated till now"},{prepend:t(()=>[e(h,{style:{color:"#4154f1",background:"#f6f6fe"},icon:"mdi-file-sign"})]),append:t(()=>[a("span",re,n(O.value),1)]),default:t(()=>[e(x,{align:"center",justify:"center",dense:""},{default:t(()=>[e(o,{cols:"4",align:"center",justify:"center",dense:""},{default:t(()=>[e(_,null,{default:t(()=>[e(u,{class:"dashboard-sub-count"},{default:t(()=>[s(n(f.value.pendings),1)]),_:1}),e(m,{class:"dashboard-sub-details"},{default:t(()=>[s(" document "),ie,s("pending ")]),_:1})]),_:1})]),_:1}),e(o,{cols:"4",align:"center",justify:"center",dense:""},{default:t(()=>[e(_,null,{default:t(()=>[e(u,{class:"dashboard-sub-count"},{default:t(()=>[s(n(f.value.shipped),1)]),_:1}),e(m,{class:"dashboard-sub-details"},{default:t(()=>[s(" document "),ue,s("shipped ")]),_:1})]),_:1})]),_:1}),e(o,{cols:"4",align:"center",justify:"center",dense:""},{default:t(()=>[e(_,null,{default:t(()=>[e(u,{class:"dashboard-sub-count"},{default:t(()=>[s(n(f.value.delivered),1)]),_:1}),e(m,{class:"dashboard-sub-details"},{default:t(()=>[s(" document "),me,s("delivered ")]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1},512),[[k,!i(r)]]),e(o,{cols:"12",md:"6"},{default:t(()=>[e(I,{title:"Total",class:"mx-auto card-shadow dashboard-card mb-5",subtitle:"Total no. of students enrolled till now"},{prepend:t(()=>[e(h,{style:{color:"#2eca6a",background:"#e0f8e9"},icon:"mdi-cards-variant"})]),append:t(()=>[a("span",_e,n($.value),1)]),default:t(()=>[e(x,{align:"center",justify:"center",dense:""},{default:t(()=>[e(o,{cols:"4",align:"center",justify:"center",dense:""},{default:t(()=>[e(_,null,{default:t(()=>[e(u,{class:"dashboard-sub-count"},{default:t(()=>[s(n(f.value.passed),1)]),_:1}),e(m,{class:"dashboard-sub-details"},{default:t(()=>[s(" student "),fe,s("passed ")]),_:1})]),_:1})]),_:1}),e(o,{cols:"4",align:"center",justify:"center",dense:""},{default:t(()=>[e(_,null,{default:t(()=>[e(u,{class:"dashboard-sub-count"},{default:t(()=>[s(n(f.value.failed),1)]),_:1}),e(m,{class:"dashboard-sub-details"},{default:t(()=>[s(" student "),he,s("failed ")]),_:1})]),_:1})]),_:1}),e(o,{cols:"4",align:"center",justify:"center",dense:""},{default:t(()=>[e(_,null,{default:t(()=>[e(u,{class:"dashboard-sub-count"},{default:t(()=>[s(n(f.value.failed),1)]),_:1}),e(m,{class:"dashboard-sub-details"},{default:t(()=>[s(" student "),pe,s("pendings ")]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})]),_:1}),e(F,{class:"my-4"}),e(j,{class:""},{default:t(()=>[e(x,{class:"mt-4 mb-4"},{default:t(()=>[e(o,{cols:"12",md:"7"},{default:t(()=>[i(r)?(b(),V(D,{key:0,elevation:"8",height:"150",type:"table-heading, list-item-two-line, image, table-tfoot"})):z("",!0),w(e(j,{class:"v-card v-theme--light v-card--density-default v-card--variant-elevated mx-auto card-shadow dashboard-card mb-5"},{default:t(()=>[e(de)]),_:1},512),[[k,!i(r)]])]),_:1}),e(o,{cols:"12",md:"5"},{default:t(()=>[i(r)?(b(),V(D,{key:0,elevation:"8",type:"table-heading, list-item-two-line, image, table-tfoot"})):z("",!0),w(e(I,{class:"v-card v-theme--light v-card--density-default v-card--variant-elevated mx-auto card-shadow mb-5"},{default:t(()=>[e(R,{"fixed-header":"",class:"glass-table","aria-describedby":"line-chart-table"},{default:t(()=>[a("thead",null,[a("tr",null,[be,a("th",ve,[e(h,{size:"large",icon:"mdi-alert-octagon-outline",class:"mx-1",style:{color:"rgb(241 68 65)",background:"rgb(255 231 231)",width:"40px",height:"40px","border-radius":"50px"}}),s(" Pending ")]),a("th",ge,[e(h,{size:"large",icon:"mdi-rocket",class:"mx-1",style:{color:"rgb(241 146 65)",background:"rgb(255 239 231)",width:"40px",height:"40px","border-radius":"50px"}}),s(" Shipped")]),a("th",ye,[e(h,{size:"large",icon:"mdi-check-decagram-outline",class:"mx-1",style:{color:"rgb(20 202 109)",background:"rgb(231 255 235)",width:"40px",height:"40px","border-radius":"50px"}}),s(" Delivered ")])])]),a("tbody",null,[(b(!0),q(J,null,W(y.categories.slice(0,5),(S,T)=>(b(),q("tr",{key:T},[a("td",xe,n(S),1),a("td",we,n(y.series[0].data[T]),1),a("td",ke,n(y.series[1].data[T]),1),a("td",Ee,n(y.series[2].data[T]),1)]))),128))])]),_:1})]),_:1},512),[[k,!i(r)]])]),_:1})]),_:1}),e(F,{class:"my-4"}),e(x,{class:"mt-5 mb-4"},{default:t(()=>[e(o,{cols:"12",md:"4"},{default:t(()=>[i(r)?(b(),V(D,{key:0,elevation:"8",type:"table-heading, list-item-two-line, image, table-tfoot",height:"500"})):z("",!0),w(e(j,{class:"v-card v-theme--light v-card--density-default v-card--variant-elevated mx-auto card-shadow mb-5"},{default:t(()=>[e(se,{summaryData:f.value},null,8,["summaryData"])]),_:1},512),[[k,!i(r)]])]),_:1}),e(o,{cols:"12",md:"8"},{default:t(()=>[e(j,{class:"v-card v-theme--light v-card--density-default v-card--variant-elevated mx-auto card-shadow mb-5"},{default:t(()=>[i(r)?(b(),V(D,{key:0,elevation:"8",type:"table-heading, list-item-two-line, image, table-tfoot",height:"400"})):z("",!0),e(x,{align:"center",justify:"space-between"},{default:t(()=>[w(e(o,{cols:"12",md:"4"},{default:t(()=>[e(U,{label:"Select Exam Cycle",modelValue:i(E),"onUpdate:modelValue":l[0]||(l[0]=S=>X(E)?E.value=S:E=S),items:B.value,variant:"outlined",color:"primary","prepend-icon":"mdi-calendar",class:"w-100"},null,8,["modelValue","items"])]),_:1},512),[[k,!i(r)]]),w(e(o,{cols:"12",md:"8"},{default:t(()=>[e(le,{examCycleData:N.value},null,8,["examCycleData"])]),_:1},512),[[k,!i(r)]])]),_:1})]),_:1})]),_:1})]),_:1})]),_:1})])])])],64)}}},Ie=oe(Ce,[["__scopeId","data-v-35b1fd2d"]]);export{Ie as default};