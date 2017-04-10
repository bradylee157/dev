Readme_css.txt

Information about some css settings for standard configuration for teaser and navigation buttons

Note: do not forget to adapt background/forground colors for teaser box and for navigation indicators/buttons accordingly to the template background (light or dark)

-----------------------------------------------------------------------------------------------------------------------------
1) Initial install
Picture sizes: 565*290 px
Box caption attached to the bottom of gallery and caption width = picture width
The height of the caption is automatically adapted to cope with title and teaser content.

Parameters:

Gallery wrapper css: none on install

Gallery CSS: no border
border: solid 0px #000;

Title CSS: (title formatting)
font-weight: bold; font-size: 16px;

Teaser box CSS: (positonning, appearance and teaser formatting)
width:565px !important; margin-bottom:0px; margin-left:0px; padding:10px;

Navigation buttons css: (positionning) outside picture, centered and at 10px under the picture bottom
width:565px !important; margin-bottom:0px; margin-left:0px; padding: 10px;

Navigation buttons link CSS:  for navigation indicators/buttons
border:1px solid #B8C4CF !important; margin-left: 5px; height: 10px; width: 10px; float: left; color: #B8C4CF; 
text-indent: -1000px; -webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;

Notes:
- the text-ident hide the slide number. If yoy want to display side number, remove the text-indent statement.
- if you do not like tounded corners for navigation indicators, remove the 3 xxx-radius statements
- adapt indicators border/backgroud colors as needed

Navigation button active link CSS:
background-color:#B8C4CF !important;

----------------------------------------------------------------------------------------------------------------------------

2) CSS to be modified for caption box positionned surimposed on the picture on left or right

2a) Teaser inside picture, width 300px, bottom left point starting at 20px left and 20px from bottom, box rounded 4px (only for css3 aware browser, not IE6,7,8). The height of the teaser caption adapts automatically to the content.
Teaser box CSS:
width:300px !important; margin-bottom:20px; margin-left:20px; padding:10px; -webkit-border-radius: 2px;-moz-border-radius: 2px;border-radius: 2px;

Please adapt width and margin-left to define the bottom-left starting point of the teaaser box position

----------------------------------------------------------------------------------------------------------------------------

3) CSS to be modified for navigation/indicators buttons

1b) inside picture, buttons on the right at 440px from left and 15px from bottom
Navigation buttons css:
left:440px !important; margin-left:0 !important; position:absolute !important; bottom:15px; padding:0 !important;

1c) inside picture,  button settings on the left at 15px and 15px from bottom
Navigation buttons css:
left:15px !important; margin-left:0 !important; position:absolute !important; bottom:15px; padding:0 !important;





