function formata(a,b,c){var d="ABCDEFGHIJKLMNOPQRSTUVWXYZ";var e="abcdefghijklmnopqrstuvwxyz";var f="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";var g="0123456789";var h="().-:/ ";var i=" !\"#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[]^_/`abcdefghijklmnopqrstuvwxyz{|}~";c=c?c:window.event?window.event:"";var j=a.value;if(c){var k=c.which?c.which:c.keyCode;tecla=i.substr(k-32,1);if(k<32)return true;var l=j.length;if(l>=b.length)return false;var m=b.substr(l,1);while(h.indexOf(m)!=-1){j+=m;l=j.length;if(l>=b.length)return false;m=b.substr(l,1)}switch(m){case"#":if(g.indexOf(tecla)==-1)return false;break;case"A":if(d.indexOf(tecla)==-1)return false;break;case"a":if(e.indexOf(tecla)==-1)return false;break;case"Z":if(f.indexOf(tecla)==-1)return false;break;case"*":a.value=j;return true;break;default:return false;break}}a.value=j;return true}
function numeros(){if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;}
function letras(){if (event.keyCode < 45 || event.keyCode > 57) {event.returnValue = true}else{ event.returnValue = false};}

/* Exemplo

 <input type="text" name="uf" id="uf" maxlength="2" onkeypress="letras()" />
 

 <input type="text" name="fone" id="fone" maxlength="13" onkeypress="numeros(); return formata(this,'(##)####-####',event)"/>

 */