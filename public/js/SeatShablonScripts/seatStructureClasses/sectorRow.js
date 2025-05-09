import { rowSeat } from "/js/SeatShablonScripts/seatStructureClasses/rowSeat.js";

export class sectorRow{

    constructor(){
        this.seats = [];
        // this.addSeat();
    }

    deepClone() {
        const clone = new sectorRow();
        clone.seats = this.seats.map(seat => seat.deepClone());
        return clone;
    }

    getSeats() {
        return this.seats;
    }

    setSeats(seats) {
        this.seats = seats;
    }

    addSeat() {
        this.seats.push(new rowSeat());
        return this;
    }

    addSeatCopy(ClassSeat) {
        let objectCopy = ClassSeat.deepClone();
        this.seats.push(objectCopy);
        return this;
    }

    delSeat(seats) {
        const index = this.seats.indexOf(seats);
        if (index !== -1) {
            this.seats.splice(index, 1);
        }
        return this;
    }

    delLastSeat() {
        this.seats.splice(-1);
        return this;
    }

}
