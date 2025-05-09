export class rowSeat{

    constructor(){
        this.available = true;
    }

    deepClone(){
        const clone = new rowSeat();
        clone.available = this.available;
        return clone;

    }

    getSeatStatus() {
        return this.available;
    }

    setSeatStatus(status) {
        this.available = status;
    }

}
