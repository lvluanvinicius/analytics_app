import { Button } from "../ui/button";

export function UsersTable() {
    return (
        <table className="w-full border-collapse text-left">
            <thead>
                <tr>
                    <th className="border-b">ID</th>
                    <th className="border-b">Nome</th>
                    <th className="border-b">E-mail</th>
                    <th className="border-b">Usuário</th>
                    <th className="border-b">Data de Criação</th>
                    <th className="border-b">Data de Modificação</th>
                    <th className="border-b"></th>
                </tr>
            </thead>
            <tbody>
                {[0, 1, 2, 3, 4, 5, 6, 7, 8, 9].map((item) => {
                    return (
                        <tr key={item}>
                            <td className="border-b py-1">902</td>
                            <td className="border-b py-1">Luan VP Santos</td>
                            <td className="border-b py-1">
                                lvluansantos@gmail.com
                            </td>
                            <td className="border-b py-1">lvluansantos</td>
                            <td className="border-b py-1">
                                10/10/2022 as 14:32
                            </td>
                            <td className="border-b py-1">
                                10/10/2022 as 14:32
                            </td>
                            <td className="border-b py-1">
                                <Button variant={"outline"} className="h-8">
                                    Editar
                                </Button>
                            </td>
                        </tr>
                    );
                })}
            </tbody>
        </table>
    );
}
