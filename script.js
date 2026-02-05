fetch('data/results.csv')
.then(res=>res.text())
.then(text=>{
const rows=text.trim().split('
').slice(1);
const table=document.getElementById('resultTable');
const input=document.getElementById('search');
input.addEventListener('keyup',()=>{
const gr=input.value.trim();
table.innerHTML='<tr><th>GR</th><th>Name</th><th>Std</th><th>Total</th></tr>';
rows.forEach(r=>{
const c=r.split(',');
if(c[0]===gr){
table.innerHTML+=`<tr><td>${c[0]}</td><td>${c[1]}</td><td>${c[2]}</td><td>${c[3]}</td></tr>`;
}
});
});
});
```javascript
// Result CSV load
fetch('data/results.csv')
.then(res => res.text())
.then(data => console.log(data));


// Notice CSV load
fetch('data/notices.csv')
.then(res => res.text())
.then(data => console.log(data));
