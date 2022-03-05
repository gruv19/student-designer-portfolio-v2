import getTypes from './types';

const getRandom = (lower, upper) => Math.floor(lower + Math.random() * (upper - lower + 1));

const textGenerate = (length) => {
  const chars = ' abdehkmnpswxzABDEFGHKMNPQRSTWXZ123456789';
  let result = '';
  for (let i = 0; i < length; i += 1) {
    const position = getRandom(0, chars.length);
    result += chars.substring(position, position + 1);
  }
  return result.trim();
};

const workGenerate = () => {
  const workTypes = getTypes();
  const id = Date.now() + parseInt(Math.random() * 1000, 10);
  const link = ['', `http:/${textGenerate(getRandom(5, 10))}.ru`];
  const workObject = {
    id,
    type: workTypes[getRandom(0, workTypes.length - 1)],
    mainImage: `https://imgholder.ru/720x480/8270DE/F5F5F5.jpg&text=${id}&font=arial`,
    title: textGenerate(getRandom(4, 10)),
    subtitle: textGenerate(getRandom(10, 20)),
    task: textGenerate(getRandom(70, 390)),
    link: link[getRandom(0, 1)],
  };
  return workObject;
};

function worksGenerate(worksCount) {
  const works = [];
  for (let i = 0; i < worksCount; i += 1) {
    works.push(workGenerate());
  }
  return works;
}

function workPresentationGenerate(workId) {
  return workId;
}

export {
  worksGenerate,
  workPresentationGenerate,
};
