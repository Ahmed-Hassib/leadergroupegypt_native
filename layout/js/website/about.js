function confirm_delete_text(btn) {
  if (!confirm(lang.delete_confirm)) return;
  // create new link
  let new_link = `${location.origin}${location.pathname}${btn.dataset.href}`;
  // redirect page
  location.href = new_link;
}