import { UserProps } from "@/services/queries/get-users";
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "../ui/table";
import { dateExtFormatter } from "@/utils/formatter";
import { UsersEdit } from "./users-edit";
import { UsersDelete } from "./users-delete";

interface UsersTableProps {
    users: UserProps[];
}

export function UsersTable({ users }: UsersTableProps) {
    return (
        <div className="w-full flex-1 overflow-auto">
            <Table className="mt-4 !w-full !min-w-[600px] !border-collapse">
                <TableHeader>
                    <TableRow>
                        <TableHead className="whitespace-nowrap border-b">
                            ID
                        </TableHead>
                        <TableHead className="whitespace-nowrap border-b">
                            Nome
                        </TableHead>
                        <TableHead className="whitespace-nowrap border-b">
                            E-mail
                        </TableHead>
                        <TableHead className="whitespace-nowrap border-b">
                            Usuário
                        </TableHead>
                        <TableHead className="whitespace-nowrap border-b">
                            Data de Criação
                        </TableHead>
                        <TableHead className="whitespace-nowrap border-b">
                            Data de Modificação
                        </TableHead>
                        <TableHead className="whitespace-nowrap border-b"></TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    {users.map((user) => {
                        return (
                            <TableRow key={user.id}>
                                <TableCell className="whitespace-nowrap border-b py-1 font-medium">
                                    {user.id}
                                </TableCell>
                                <TableCell className="whitespace-nowrap border-b py-1 font-medium">
                                    {user.name}
                                </TableCell>
                                <TableCell className="whitespace-nowrap border-b py-1 font-medium">
                                    {user.email}
                                </TableCell>
                                <TableCell className="whitespace-nowrap border-b py-1 font-medium">
                                    {user.username}
                                </TableCell>
                                <TableCell className="whitespace-nowrap border-b py-1 font-medium">
                                    {dateExtFormatter(user.created_at)}
                                </TableCell>
                                <TableCell className="whitespace-nowrap border-b py-1 font-medium">
                                    {dateExtFormatter(user.updated_at)}
                                </TableCell>
                                <TableCell className="whitespace-nowrap border-b py-1 font-medium">
                                    <div className="flex items-center justify-center gap-4">
                                        <UsersEdit
                                            user={{ ...user, password: "" }}
                                        />
                                        <UsersDelete userId={user.id} />
                                    </div>
                                </TableCell>
                            </TableRow>
                        );
                    })}
                </TableBody>
            </Table>
        </div>
    );
}
