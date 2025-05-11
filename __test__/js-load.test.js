const fs = require('fs');
const path = require('path');

const directoryToTest = path.join(__dirname, '../public/assets/js');

function getAllJsFiles(dir, fileList = []) {
  const files = fs.readdirSync(dir);
  files.forEach((file) => {
    const filePath = path.join(dir, file);
    const stat = fs.statSync(filePath);
    if (stat.isDirectory()) {
      getAllJsFiles(filePath, fileList);
    } else if (file.endsWith('.js')) {
      fileList.push(filePath);
    }
  });
  return fileList;
}

describe('Chargement de tous les fichiers JS', () => {
  const jsFiles = getAllJsFiles(directoryToTest);

  jsFiles.forEach((file) => {
    test(`Chargement sans erreur : ${path.relative(__dirname, file)}`, () => {
      expect(() => require(file)).not.toThrow();
    });
  });
});
