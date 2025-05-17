
export class TicketsOrderList {
    constructor() {
        this.tickets = new Map();
    }

    addTicket(ticketId) {
        this.tickets.set(ticketId, false);
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
}