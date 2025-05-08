
export class ZoneSector {
    constructor() {
        this.rowCount = 1;
        this.seatsInRow = 1;
    }

    deepClone() {
        const clone = new ZoneSector();
        clone.rowCount = this.rowCount;
        clone.seatsInRow = this.seatsInRow;

        return clone;
    }

    getRowCount() {
        return this.rowCount;
    }

    setRowCount(rowCount) {
        this.rowCount = rowCount;
        return this;
    }

    getSeatsInRow() {
        return this.seatsInRow;
    }

    setSeatsInRow(seatsInRow) {
        this.seatsInRow = seatsInRow;
        return this;
    }

    increaseSeatsInRow() {
        this.seatsInRow++;
        return this;
    }

    decreaseSeatsInRow() {
        this.seatsInRow--;
        return this;
    }

    increaseRowInSector() {
        this.rowCount++;
        return this;
    }

    decreaseRowInSector() {
        this.rowCount--;
        return this;
    }
}