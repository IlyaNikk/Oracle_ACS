let row = document.getElementsByTagName('tr');
row = Array.prototype.slice.call(row);
let cellsLen = row[0].getElementsByTagName('td');
cellsLen = Array.prototype.slice.call(cellsLen).filter((item) => item.className.indexOf('hidden') === -1);
const wid = row[0].clientWidth / cellsLen.length;
setEqualWidth(row, 'td');
row = Array.prototype.slice.call(document.getElementsByClassName('form__select-result'));
setEqualWidth(row, 'div');

function setEqualWidth(parentElem, childElem) {
    parentElem.forEach((item, num) => {
        let cells = Array.prototype.slice.call(row[num].getElementsByTagName(childElem))
            .filter((item) => item.className.indexOf('hidden') === -1);
        cells.forEach(cell => {
            cell.style.width = `${wid.toString()}px`;
        })
    })
}
//
// let updateButtons = document.getElementsByClassName('update-button');
// if (updateButtons.length > 1) {
//     updateButtons = Array.prototype.slice.call(updateButtons);
//     updateButtons.forEach((item) => {
//         item.addEventListener('click', (event) => {
//             let elements = event.target.parentNode.parentNode.getElementsByClassName('select-result__cell');
//             elements = Array.prototype.slice.call(elements);
//             switch (event.target.innerText) {
//                 case 'Редактировать':
//                     elements.forEach((element, position) => {
//                         let input = document.createElement('input');
//                         input.value = element.innerText;
//                         input.placeholder = row[0].childNodes[position + 1].childNodes[0].placeholder;
//                         element.innerText = '';
//                         element.appendChild(input);
//                         event.target.innerText = 'Сохранить';
//                     });
//                     break;
//                 case 'Сохранить':
//                     let result = {};
//                     elements.forEach((element) => {
//                        result[element.childNodes[0].placeholder] = element.childNodes[0].value;
//                     });
//                     result.table_name = window.location.search.match(/^\?table_name=(\w*)$/)[1];
//                     result.id = +event.target.parentNode.parentNode.querySelector('td.hidden input').value;
//                     let head = new Headers();
//                     head.append("Content-type", "application/x-www-form-urlencoded")
//                     fetch('update.php', {
//                         method: 'POST',
//                         headers: head,
//                         body: result
//                     });
//                     break;
//             }
//         })
//     })
// }
//
//
