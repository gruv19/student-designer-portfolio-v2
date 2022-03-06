async function fetchWorks(from) {
  const data = await fetch(`/api/getWorks.php?from=${from}`);
  const result = await data.json();
  return result;
}

async function fetchWorkImages(id) {
  const data = await fetch(`/api/getWorkData.php?work_id=${id}`);
  const result = await data.json();
  return result;
}

export {
  fetchWorks,
  fetchWorkImages,
};
