
let deleted_piece_name_in_modal = document.querySelector('#deleted-piece-name');
let deleted_piece_url_in_modal = document.querySelector('#deleted-piece-url');

function confirm_delete_piece(btn, will_back = null) {
  // get piece info
  let piece_id = btn.dataset.pieceId;
  let piece_name = btn.dataset.pieceName;
  let page_title = btn.dataset.pageTitle;
  // prepare url
  let url = will_back == null ? `?do=delete-piece&piece-id=${piece_id}` : `?do=delete-piece&piece-id=${piece_id}&back=true`;
  // put it into the modal
  deleted_piece_name_in_modal.textContent = `'${piece_name}'`;
  deleted_piece_url_in_modal.href = url;
}