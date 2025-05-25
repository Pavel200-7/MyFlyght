
export class TicketsOrderList {
    constructor() {
        this.tickets = new Map();
    }

    addTicket(ticketId, seatPlace) {
        this.tickets.set(ticketId, [false, seatPlace]);
    }

    delTicket(ticketId) {
        this.tickets.delete(ticketId);
    }

    changeBaggageStatus(ticketId) {
        let currentStatus = this.tickets.get(ticketId);
        if (currentStatus !== undefined) {
            this.tickets.set(ticketId, !currentStatus);
        }
    }

    getBaggageStatus(ticketId) {
        return this.tickets.get(ticketId);
    }

    toJSON() {
        // Map надо превратить в обычный объект или массив
        const obj = Object.create(null);
        for (let [key, value] of this.tickets) {
            obj[key] = value;
        }
        return obj;
    }
}