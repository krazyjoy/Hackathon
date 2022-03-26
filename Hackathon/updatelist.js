var inner = "";
for (var i = 0; i < jbig.length; i++) {
	inner += `<option value=i>${jbig[i]}</option>`;
}
var s1=document.getElementById("list1");
var s2=document.getElementById("list2");
var s3=document.getElementById("list3");
var s4=document.getElementById("list4");
var s5=document.getElementById("list5");
var s6=document.getElementById("list6");
s1.innerHTML=inner;
s4.innerHTML=inner;
var id="2000000000";
var index;
var noIndex; //第二層的index b 
//選擇第一層後，產出第二層
var index1,index2,index3;
s1.selectedIndex=0;
s4.selectedIndex=0;

function update1()
{	
	index = s1.selectedIndex;//第一層的index
	noIndex = index;
	s2.options.length = 0;
	s3.options.length = 0;
	for (var i = 0; i < jmid[index].length; i++) {
		s2.add(new Option(jmid[index][i],i));
	}
	s2.selectedIndex=0;
	s3.selectedIndex=0;
	update2();
}
function update2()
{	
	index = s2.selectedIndex;//第一層的index
	s3.options.length = 0;
	for (var i = 0; i < jsmall[noIndex][index].length; i++) {
		s3.add(new Option(jsmall[noIndex][index][i],i));
	}
	s3.selectedIndex=0;
}
function update4()
{	
	index1 = s4.selectedIndex;//第一層的index
	noIndex = index1;
	s5.options.length = 0;
	s6.options.length = 0;
	for (var i = 0; i < jmid[index1].length; i++) {
		s5.add(new Option(jmid[index1][i],i));
	}
	s5.selectedIndex=0;
	s6.selectedIndex=0;
	update5();
	update6();	
}
function update5()
{	
	index2 = s5.selectedIndex;//第一層的index
	s6.options.length = 0;
	for (var i = 0; i < jsmall[noIndex][index2].length; i++) {
		s6.add(new Option(jsmall[noIndex][index2][i],i));
	}
	s6.selectedIndex=0;
	update6();
}
function update6()
{
	index3 = s6.selectedIndex;
	id = "20" + ((index1 >= 10) ? (index1).toString() : ("0" + (index1).toString()))
		+ "0" + ((index2 >= 10) ? (index2).toString() : ("0" + (index2).toString())) + "0"
		+ ((index3 >= 10) ? (index3).toString() : ("0" + (index3).toString()));
	console.log(id);
}
function express(){
	location.href="displayjob.php?value=" +id;
}