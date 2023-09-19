function confirm_delete_link(btn) {
  if (!confirm(lang.delete_confirm)) return;
  // create new link
  let new_link = `${location.origin}${location.pathname}${btn.dataset.href}`;
  // redirect page
  location.href = new_link;
}