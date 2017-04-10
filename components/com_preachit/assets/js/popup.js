function showPopup(url) {
newwindow=window.open(url,'miniwin','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=0,width=600,height=300');
if (window.focus) {newwindow.focus()}
}
