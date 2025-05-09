import { sectorRow } from "/js/SeatShablonScripts/seatStructureClasses/sectorRow.js";

export class zoneSector {
    constructor() {
        this.rows =  [];
    }

    deepClone() {
        const clone = new zoneSector();
        clone.rows = this.rows.map(row => row.deepClone());

        return clone;
    }

    getRows() {
        return this.rows;
    }

    setRows(rows) {
        this.rows = rows;
        return this;
    }

    addRow() {
        this.rows.push(new sectorRow());
        return this;
    }

    addNewRow() {
        let row = new sectorRow();
        row.addSeat();
        this.rows.push(row);
        return this;
    }

    addRowCopy(ClassRow) {
        let objectCopy = ClassRow.deepClone();
        this.rows.push(objectCopy);
        return this;
    }

    delRow(ClassRow) {
        const index = this.rows.indexOf(ClassRow);
        if (index !== -1) {
            this.rows.slice(index, 1);
        }
        return this;
    }

    delLastRow() {
        this.rows.splice(-1);
        return this;
    }
}