function selectmedia(media)
{
        if (media == 'video')
        {
            if (document.getElementById("pivideocontainer"))
            {document.getElementById('pivideocontainer').style.display = 'block';}
            if (document.getElementById("pivideolink"))
            {document.getElementById("pivideolink").className = "pilink picurrent";}
            if (document.getElementById("piaudiocontainer"))
            {document.getElementById('piaudiocontainer').style.display = 'none';}
            if (document.getElementById("piaudiolink"))
            {document.getElementById("piaudiolink").className = "pilink pinotcurrent";}
        }
        if (media == 'audio')
        {
            if (document.getElementById("pivideocontainer"))
            {document.getElementById('pivideocontainer').style.display = 'none';}
            if (document.getElementById("pivideolink"))
            {document.getElementById("pivideolink").className = "pilink pinotcurrent";}
            if (document.getElementById("piaudiocontainer"))
            {document.getElementById('piaudiocontainer').style.display = 'block';}
            if (document.getElementById("piaudiolink"))
            {document.getElementById("piaudiolink").className = "pilink picurrent";}
        }
}

