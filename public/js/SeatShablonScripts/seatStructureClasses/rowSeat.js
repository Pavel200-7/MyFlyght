export class rowSeat{

    constructor(){
        this._available = true;
        this._seatId = 1;
    }

    deepClone(){
        const clone = new rowSeat();
        clone._available = this._available;
        clone._seatId = this._seatId;
        return clone;

    }

    get available() {
        return this._available;
    }

    set available(value) {
        this._available = value;
    }

    get seatId() {
        return this._seatId;
    }

    set seatId(value) {
        this._seatId = value;
    }
}
