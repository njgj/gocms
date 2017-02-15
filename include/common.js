// JavaScript Document
function newwin(url,width,height){
   window.open(url,'','width='+width+',height='+height+', top='+(screen.availHeight-height-30)/2+', left='+(screen.availWidth-width-10)/2+', toolbar=no, menubar=no, scrollbars=yes, resizable=yes,location=no, status=no');
}

//按比例生成缩略图
function DrawImage(ImgD,W,H){ 
  var flag=false; 
  var image=new Image(); 
  image.src=ImgD.src; 
  if(image.width>0 && image.height>0){ 
    flag=true; 
    if(image.width/image.height>= W/H){ 
      if(image.width>W){
        ImgD.width=W; 
        ImgD.height=(image.height*H)/image.width; 
      }
	  else{ 
        ImgD.width=image.width;
        ImgD.height=image.height; 
      } 
      ImgD.alt= ""; 
    } 
    else{ 
      if(image.height>H){
        ImgD.height=H; 
        ImgD.width=(image.width*W)/image.height; 
      }
	  else{ 
        ImgD.width=image.width;
        ImgD.height=image.height; 
      } 
      ImgD.alt=""; 
    } 
  }
}