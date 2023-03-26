var media_container = document.getElementById('show-preview-media');

/**
 * 
 */
function show_media_preview (evt) {
  // // clear media container
  // media_container.innerHTML = '';
  // loop on files of the form
  for (let i = 0; i < evt.files.length; i++) {
    // uploaded type
    let type = evt.files[i]['type'].includes('video') ? 'video' : 'img';
    // create the image src
    var src = URL.createObjectURL(evt.files[i]);
    // create a colomn to append the image
    let col = document.createElement('div');
    col.classList.add('col-12');
    // element that will append to the preview box
    let element;
    // switch ... case ...
    switch (type) {
      case 'video':
        element = create_video_element(src);
        // append video source
        break;

      case 'img':
        // create image
        element = document.createElement('img');
        element.setAttribute('src', src);
        element.setAttribute('class', 'w-100 h-100');
        break;
    }
    // append image into column
    col.appendChild(element);
    // append column into the preview box
    media_container.appendChild(col)
  }
}


function create_video_element(video_src) {
  // create video
  let video_element = document.createElement('video');
  video_element.classList.add('w-100', 'h-100');
  video_element.autoplay = 'autoplay';
  video_element.muted = true;
  video_element.controls = true;
  // video_element.loop = true;
  
  // create source tag
  let video_source_mp4 = document.createElement('source');
  video_source_mp4.src = video_src;
  video_source_mp4.type = `video/mp4`;
  video_element.appendChild(video_source_mp4);
  
  // create source tag
  let video_source_mov = document.createElement('source');
  video_source_mov.src = video_src;
  video_source_mov.type = `video/mov`;
  video_element.appendChild(video_source_mov);
  
  // create source tag
  let video_source_webm = document.createElement('source');
  video_source_webm.src = video_src;
  video_source_webm.type = `video/webm`;
  video_element.appendChild(video_source_webm);
  
  // return video element
  return video_element;
}