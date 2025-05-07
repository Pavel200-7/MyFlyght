export class ZoneSector {
    constructor() {
        this.rowCount = 1;
        this.seatsInRow = 1;
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

    increaseSeatsInSector() {
        this.seatsInRow++;
        return this;
    }

    decreaseSeatsInSector() {
        this.seatsInRow--;
        return this;
    }
}