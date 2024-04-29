import { Button } from "../ui/button";
import { Input } from "../ui/input";

export function UsersFilter() {
    return (
        <div className="mb-2 w-full ">
            <form className="flex w-full gap-2">
                <Input placeholder="Buscar usuário" className="flex-1" />
                <Button variant="outline" type="submit">
                    Filtrar
                </Button>
                <Button variant="outline" type="button">
                    Limpar Filtro
                </Button>
            </form>
        </div>
    );
}
