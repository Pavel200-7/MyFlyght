export class rowSeat{

    constructor(){
        this._available = true;
        this._chosen = false;

        this._seatId = 1;
    }

    deepClone(){
        const clone = new rowSeat();
        clone._available = this._available;
        clone._chosen = this._chosen;
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

    get chosen() {
        return this._chosen;
    }

    set chosen(value) {
        this._chosen = value;
    }


}
