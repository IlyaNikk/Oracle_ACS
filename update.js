let row = document.getElementsByClassName('update-result__columns');
row = Array.prototype.slice.call(row);
let cellsLen = row[0].getElementsByTagName('div');
cellsLen = Array.prototype.slice.call(cellsLen).filter((item) => item.className.indexOf('hidden') === -1);
const wid = row[0].clientWidth / cellsLen.length;
setEqualWidth(row, 'div');
row = Array.prototype.slice.call(document.getElementsByClassName('update-result__result'));
setEqualWidth(row, 'input');

function setEqualWidth(parentElem, childElem) {
    parentElem.forEach((item, num) => {
        let cells = Array.prototype.slice.call(row[num].getElementsByTagName(childElem))
            .filter((item) => item.className.indexOf('hidden') === -1);
        cells.forEach(cell => {
            cell.style.width = `${wid.toString()}px`;
        })
    })
}