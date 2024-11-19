import { parseISO, format } from "date-fns";
import { ptBR } from "date-fns/locale";

export const dateExtFormatter = (date: string) => {
    return format(parseISO(date), `'dia' dd MMMM yyyy 'às' HH:mm`, {
        locale: ptBR,
    });
};
