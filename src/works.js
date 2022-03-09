async function fetchWorks(from, filter = 'all') {
  let uri = `/api/getWorks.php?from=${from}&filter=${filter}`;
  if (process.env.NODE_ENV === 'development') {
    uri = `http://design-student-vue-2/api/getWorks.php?from=${from}&filter=${filter}`;
  }
  const data = await fetch(uri);
  const result = await data.json();
  return result;
}

async function fetchWorkImages(id) {
  let uri = `/api/getWorkData.php?work_id=${id}`;
  if (process.env.NODE_ENV === 'development') {
    uri = `http://design-student-vue-2/api/getWorkData.php?work_id=${id}`;
  }
  const data = await fetch(uri);
  const result = await data.json();
  return result;
}

export {
  fetchWorks,
  fetchWorkImages,
};
